<?php
/**
 * Class WCLSI_Sync_Manager
 * Handles synchronization status tracking and management
 */
class WCLSI_Sync_Manager {
    private const SYNC_STATUS_KEY = 'wclsi_sync_status';
    private const SYNC_HISTORY_KEY = 'wclsi_sync_history';
    private const MAX_HISTORY_ENTRIES = 100;
    private const SYNC_INTERVAL = 300; // 5 minutes

    private WCLSI_Error_Logger $logger;
    private bool $is_syncing = false;
    private int $last_sync_time = 0;
    private array $sync_status = [];
    private array $sync_history = [];

    /**
     * Initialize the sync manager
     * @param WCLSI_Error_Logger $logger Error logger
     */
    public function __construct(WCLSI_Error_Logger $logger) {
        $this->logger = $logger;
        $this->load_sync_status();
        $this->load_sync_history();
    }

    /**
     * Start synchronization process
     * @return bool True if sync started successfully
     */
    public function start_sync(): bool {
        if ($this->is_syncing) {
            $this->logger->log('Sync already in progress');
            return false;
        }

        if (!$this->can_start_sync()) {
            $this->logger->log('Sync cannot start - too soon after last sync');
            return false;
        }

        $this->is_syncing = true;
        $this->last_sync_time = time();
        $this->update_sync_status([
            'status' => 'in_progress',
            'start_time' => $this->last_sync_time,
            'items_processed' => 0,
            'errors' => []
        ]);

        return true;
    }

    /**
     * End synchronization process
     * @param array $stats Sync statistics
     */
    public function end_sync(array $stats): void {
        $this->is_syncing = false;
        $this->update_sync_status([
            'status' => 'completed',
            'end_time' => time(),
            'duration' => time() - $this->last_sync_time,
            'items_processed' => $stats['items_processed'] ?? 0,
            'items_updated' => $stats['items_updated'] ?? 0,
            'items_created' => $stats['items_created'] ?? 0,
            'items_failed' => $stats['items_failed'] ?? 0,
            'errors' => $stats['errors'] ?? []
        ]);

        $this->add_sync_history_entry($this->sync_status);
    }

    /**
     * Update sync status
     * @param array $status New status data
     */
    public function update_sync_status(array $status): void {
        $this->sync_status = array_merge($this->sync_status, $status);
        update_option(self::SYNC_STATUS_KEY, $this->sync_status);
    }

    /**
     * Get current sync status
     * @return array Sync status
     */
    public function get_sync_status(): array {
        return $this->sync_status;
    }

    /**
     * Get sync history
     * @param int $limit Number of entries to return
     * @return array Sync history
     */
    public function get_sync_history(int $limit = 10): array {
        return array_slice($this->sync_history, 0, $limit);
    }

    /**
     * Check if sync can start
     * @return bool True if sync can start
     */
    private function can_start_sync(): bool {
        if (empty($this->last_sync_time)) {
            return true;
        }

        $time_since_last_sync = time() - $this->last_sync_time;
        return $time_since_last_sync >= self::SYNC_INTERVAL;
    }

    /**
     * Load sync status from database
     */
    private function load_sync_status(): void {
        $this->sync_status = get_option(self::SYNC_STATUS_KEY, []);
        $this->last_sync_time = $this->sync_status['end_time'] ?? 0;
    }

    /**
     * Load sync history from database
     */
    private function load_sync_history(): void {
        $this->sync_history = get_option(self::SYNC_HISTORY_KEY, []);
    }

    /**
     * Add entry to sync history
     * @param array $entry Sync history entry
     */
    private function add_sync_history_entry(array $entry): void {
        array_unshift($this->sync_history, $entry);
        if (count($this->sync_history) > self::MAX_HISTORY_ENTRIES) {
            array_pop($this->sync_history);
        }
        update_option(self::SYNC_HISTORY_KEY, $this->sync_history);
    }

    /**
     * Clear sync history
     */
    public function clear_sync_history(): void {
        $this->sync_history = [];
        delete_option(self::SYNC_HISTORY_KEY);
    }

    /**
     * Reset sync status
     */
    public function reset_sync_status(): void {
        $this->sync_status = [];
        $this->is_syncing = false;
        $this->last_sync_time = 0;
        delete_option(self::SYNC_STATUS_KEY);
    }
} 