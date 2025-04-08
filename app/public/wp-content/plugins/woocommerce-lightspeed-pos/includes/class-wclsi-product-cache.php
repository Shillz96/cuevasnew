<?php
/**
 * Class WCLSI_Product_Cache
 * Handles product data caching and optimization
 */
class WCLSI_Product_Cache {
    private const CACHE_PREFIX = 'wclsi_product_';
    private const CACHE_EXPIRY = 3600; // 1 hour
    private const BATCH_SIZE = 50;
    private const MAX_CACHE_SIZE = 1000;

    private WCLSI_Api_Cache $cache;
    private array $cached_products = [];
    private array $cache_stats = [
        'hits' => 0,
        'misses' => 0,
        'updates' => 0,
        'deletes' => 0
    ];

    /**
     * Initialize the product cache
     * @param WCLSI_Api_Cache $cache Cache instance
     */
    public function __construct(WCLSI_Api_Cache $cache) {
        $this->cache = $cache;
        $this->load_cached_products();
    }

    /**
     * Get product data from cache
     * @param int $product_id Product ID
     * @return array|null Product data
     */
    public function get_product(int $product_id): ?array {
        $cache_key = self::CACHE_PREFIX . $product_id;
        
        if (isset($this->cached_products[$product_id])) {
            $this->cache_stats['hits']++;
            return $this->cached_products[$product_id];
        }

        $product_data = $this->cache->get($cache_key);
        if ($product_data) {
            $this->cached_products[$product_id] = $product_data;
            $this->cache_stats['hits']++;
            return $product_data;
        }

        $this->cache_stats['misses']++;
        return null;
    }

    /**
     * Cache product data
     * @param int $product_id Product ID
     * @param array $product_data Product data
     */
    public function set_product(int $product_id, array $product_data): void {
        $cache_key = self::CACHE_PREFIX . $product_id;
        $this->cached_products[$product_id] = $product_data;
        $this->cache->set($cache_key, $product_data, self::CACHE_EXPIRY);
        $this->cache_stats['updates']++;

        if (count($this->cached_products) > self::MAX_CACHE_SIZE) {
            $this->cleanup_cache();
        }
    }

    /**
     * Delete product from cache
     * @param int $product_id Product ID
     */
    public function delete_product(int $product_id): void {
        $cache_key = self::CACHE_PREFIX . $product_id;
        unset($this->cached_products[$product_id]);
        $this->cache->delete($cache_key);
        $this->cache_stats['deletes']++;
    }

    /**
     * Batch cache products
     * @param array $products Products to cache
     */
    public function batch_cache_products(array $products): void {
        $batches = array_chunk($products, self::BATCH_SIZE);
        
        foreach ($batches as $batch) {
            foreach ($batch as $product) {
                if (isset($product['id'])) {
                    $this->set_product($product['id'], $product);
                }
            }
        }
    }

    /**
     * Get cached products by IDs
     * @param array $product_ids Product IDs
     * @return array Cached products
     */
    public function get_products_by_ids(array $product_ids): array {
        $products = [];
        $missing_ids = [];

        foreach ($product_ids as $id) {
            $product = $this->get_product($id);
            if ($product) {
                $products[$id] = $product;
            } else {
                $missing_ids[] = $id;
            }
        }

        return [
            'products' => $products,
            'missing_ids' => $missing_ids
        ];
    }

    /**
     * Clear product cache
     */
    public function clear_cache(): void {
        $this->cached_products = [];
        $this->cache->delete_by_prefix(self::CACHE_PREFIX);
        $this->reset_stats();
    }

    /**
     * Load cached products from database
     */
    private function load_cached_products(): void {
        $cached_keys = $this->cache->get_keys_by_prefix(self::CACHE_PREFIX);
        
        foreach ($cached_keys as $key) {
            $product_id = str_replace(self::CACHE_PREFIX, '', $key);
            $product_data = $this->cache->get($key);
            if ($product_data) {
                $this->cached_products[$product_id] = $product_data;
            }
        }
    }

    /**
     * Cleanup cache by removing oldest entries
     */
    private function cleanup_cache(): void {
        $excess = count($this->cached_products) - self::MAX_CACHE_SIZE;
        if ($excess > 0) {
            $products_to_remove = array_slice($this->cached_products, 0, $excess, true);
            foreach ($products_to_remove as $id => $product) {
                $this->delete_product($id);
            }
        }
    }

    /**
     * Get cache statistics
     * @return array Cache statistics
     */
    public function get_stats(): array {
        return $this->cache_stats;
    }

    /**
     * Reset cache statistics
     */
    public function reset_stats(): void {
        $this->cache_stats = [
            'hits' => 0,
            'misses' => 0,
            'updates' => 0,
            'deletes' => 0
        ];
    }

    /**
     * Get cache size
     * @return int Number of cached products
     */
    public function get_cache_size(): int {
        return count($this->cached_products);
    }
} 