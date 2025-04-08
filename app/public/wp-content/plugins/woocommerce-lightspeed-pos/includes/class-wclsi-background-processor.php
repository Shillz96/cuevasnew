<?php
/**
 * Class WCLSI_Background_Processor
 * Handles background processing of tasks
 */
class WCLSI_Background_Processor {
    private const QUEUE_KEY = 'wclsi_background_queue';
    private const PROCESSING_KEY = 'wclsi_processing';
    private const MAX_CONCURRENT_PROCESSES = 3;
    private const PROCESS_TIMEOUT = 300; // 5 minutes

    private WCLSI_Error_Logger $logger;
    private array $queue = [];
    private array $processing = [];

    /**
     * Initialize the background processor
     * @param WCLSI_Error_Logger $logger Error logger
     */
    public function __construct(WCLSI_Error_Logger $logger) {
        $this->logger = $logger;
        $this->load_queue();
        $this->load_processing();
    }

    /**
     * Add task to queue
     * @param string $type Task type
     * @param array $data Task data
     * @return string Task ID
     */
    public function add_task(string $type, array $data): string {
        $task_id = uniqid('task_', true);
        $task = [
            'id' => $task_id,
            'type' => $type,
            'data' => $data,
            'created_at' => time(),
            'status' => 'pending'
        ];

        $this->queue[] = $task;
        $this->save_queue();
        return $task_id;
    }

    /**
     * Process next task in queue
     * @return bool True if task processed
     */
    public function process_next_task(): bool {
        if (count($this->processing) >= self::MAX_CONCURRENT_PROCESSES) {
            return false;
        }

        $task = array_shift($this->queue);
        if (!$task) {
            return false;
        }

        $this->processing[$task['id']] = $task;
        $this->save_queue();
        $this->save_processing();

        try {
            $this->execute_task($task);
            unset($this->processing[$task['id']]);
            $this->save_processing();
            return true;
        } catch (Exception $e) {
            $this->logger->log('Task processing failed: ' . $e->getMessage());
            $this->handle_failed_task($task, $e);
            return false;
        }
    }

    /**
     * Execute task
     * @param array $task Task to execute
     */
    private function execute_task(array $task): void {
        set_time_limit(self::PROCESS_TIMEOUT);

        switch ($task['type']) {
            case 'sync_products':
                $this->process_sync_products($task['data']);
                break;
            case 'update_inventory':
                $this->process_update_inventory($task['data']);
                break;
            case 'sync_categories':
                $this->process_sync_categories($task['data']);
                break;
            default:
                throw new Exception('Unknown task type: ' . $task['type']);
        }
    }

    /**
     * Process sync products task
     * @param array $data Task data
     */
    private function process_sync_products(array $data): void {
        // Implementation for syncing products
        // This would use the WCLSI_Batch_Processor
    }

    /**
     * Process update inventory task
     * @param array $data Task data
     */
    private function process_update_inventory(array $data): void {
        // Implementation for updating inventory
    }

    /**
     * Process sync categories task
     * @param array $data Task data
     */
    private function process_sync_categories(array $data): void {
        // Implementation for syncing categories
    }

    /**
     * Handle failed task
     * @param array $task Failed task
     * @param Exception $e Exception that caused failure
     */
    private function handle_failed_task(array $task, Exception $e): void {
        $task['status'] = 'failed';
        $task['error'] = $e->getMessage();
        $task['failed_at'] = time();

        // Add to failed tasks queue or retry logic
        unset($this->processing[$task['id']]);
        $this->save_processing();
    }

    /**
     * Get queue status
     * @return array Queue status
     */
    public function get_queue_status(): array {
        return [
            'queued' => count($this->queue),
            'processing' => count($this->processing),
            'total' => count($this->queue) + count($this->processing)
        ];
    }

    /**
     * Clear queue
     */
    public function clear_queue(): void {
        $this->queue = [];
        $this->save_queue();
    }

    /**
     * Load queue from database
     */
    private function load_queue(): void {
        $this->queue = get_option(self::QUEUE_KEY, []);
    }

    /**
     * Save queue to database
     */
    private function save_queue(): void {
        update_option(self::QUEUE_KEY, $this->queue);
    }

    /**
     * Load processing tasks from database
     */
    private function load_processing(): void {
        $this->processing = get_option(self::PROCESSING_KEY, []);
    }

    /**
     * Save processing tasks to database
     */
    private function save_processing(): void {
        update_option(self::PROCESSING_KEY, $this->processing);
    }

    /**
     * Clean up stale processing tasks
     */
    public function cleanup_stale_tasks(): void {
        $now = time();
        foreach ($this->processing as $task_id => $task) {
            if ($now - $task['created_at'] > self::PROCESS_TIMEOUT) {
                unset($this->processing[$task_id]);
            }
        }
        $this->save_processing();
    }
} 