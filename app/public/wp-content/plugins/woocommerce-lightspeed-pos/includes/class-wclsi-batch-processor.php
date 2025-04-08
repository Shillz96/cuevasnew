<?php
/**
 * Class WCLSI_Batch_Processor
 * Handles batch processing of products
 */
class WCLSI_Batch_Processor {
    private const BATCH_SIZE = 50;
    private const MAX_RETRIES = 3;
    private const RETRY_DELAY = 5; // seconds

    private WCLSI_Api_Router $api_router;
    private WCLSI_Data_Transformer $transformer;
    private WCLSI_Error_Logger $logger;
    private WCLSI_Sync_Manager $sync_manager;
    private array $stats = [
        'items_processed' => 0,
        'items_updated' => 0,
        'items_created' => 0,
        'items_failed' => 0,
        'errors' => []
    ];

    /**
     * Initialize the batch processor
     * @param WCLSI_Api_Router $api_router API router
     * @param WCLSI_Data_Transformer $transformer Data transformer
     * @param WCLSI_Error_Logger $logger Error logger
     * @param WCLSI_Sync_Manager $sync_manager Sync manager
     */
    public function __construct(
        WCLSI_Api_Router $api_router,
        WCLSI_Data_Transformer $transformer,
        WCLSI_Error_Logger $logger,
        WCLSI_Sync_Manager $sync_manager
    ) {
        $this->api_router = $api_router;
        $this->transformer = $transformer;
        $this->logger = $logger;
        $this->sync_manager = $sync_manager;
    }

    /**
     * Process a batch of products
     * @param array $products Products to process
     * @return bool True if batch processed successfully
     */
    public function process_batch(array $products): bool {
        if (!$this->sync_manager->start_sync()) {
            return false;
        }

        try {
            foreach ($products as $product) {
                $this->process_product($product);
            }

            $this->sync_manager->end_sync($this->stats);
            return true;
        } catch (Exception $e) {
            $this->logger->log('Batch processing failed: ' . $e->getMessage());
            $this->sync_manager->end_sync(array_merge($this->stats, [
                'status' => 'failed',
                'error' => $e->getMessage()
            ]));
            return false;
        }
    }

    /**
     * Process a single product
     * @param array $product Product data
     */
    private function process_product(array $product): void {
        $this->stats['items_processed']++;

        try {
            $wc_product = $this->transformer->ls_to_wc_product($product);
            $existing_product = $this->find_existing_product($wc_product['sku']);

            if ($existing_product) {
                $this->update_product($existing_product, $wc_product);
            } else {
                $this->create_product($wc_product);
            }
        } catch (Exception $e) {
            $this->stats['items_failed']++;
            $this->stats['errors'][] = [
                'sku' => $product['customSku'] ?? 'unknown',
                'error' => $e->getMessage()
            ];
            $this->logger->log('Failed to process product: ' . $e->getMessage());
        }
    }

    /**
     * Find existing product by SKU
     * @param string $sku Product SKU
     * @return WC_Product|null Product if found
     */
    private function find_existing_product(string $sku): ?WC_Product {
        $product_id = wc_get_product_id_by_sku($sku);
        return $product_id ? wc_get_product($product_id) : null;
    }

    /**
     * Update existing product
     * @param WC_Product $product Product to update
     * @param array $data New product data
     */
    private function update_product(WC_Product $product, array $data): void {
        $retry_count = 0;
        while ($retry_count < self::MAX_RETRIES) {
            try {
                foreach ($data as $key => $value) {
                    $setter = 'set_' . $key;
                    if (method_exists($product, $setter)) {
                        $product->$setter($value);
                    }
                }

                $product->save();
                $this->stats['items_updated']++;
                return;
            } catch (Exception $e) {
                $retry_count++;
                if ($retry_count < self::MAX_RETRIES) {
                    sleep(self::RETRY_DELAY);
                } else {
                    throw $e;
                }
            }
        }
    }

    /**
     * Create new product
     * @param array $data Product data
     */
    private function create_product(array $data): void {
        $retry_count = 0;
        while ($retry_count < self::MAX_RETRIES) {
            try {
                $product = new WC_Product_Simple();
                foreach ($data as $key => $value) {
                    $setter = 'set_' . $key;
                    if (method_exists($product, $setter)) {
                        $product->$setter($value);
                    }
                }

                $product->save();
                $this->stats['items_created']++;
                return;
            } catch (Exception $e) {
                $retry_count++;
                if ($retry_count < self::MAX_RETRIES) {
                    sleep(self::RETRY_DELAY);
                } else {
                    throw $e;
                }
            }
        }
    }

    /**
     * Get batch size
     * @return int Batch size
     */
    public function get_batch_size(): int {
        return self::BATCH_SIZE;
    }

    /**
     * Get processing statistics
     * @return array Statistics
     */
    public function get_stats(): array {
        return $this->stats;
    }

    /**
     * Reset statistics
     */
    public function reset_stats(): void {
        $this->stats = [
            'items_processed' => 0,
            'items_updated' => 0,
            'items_created' => 0,
            'items_failed' => 0,
            'errors' => []
        ];
    }
} 