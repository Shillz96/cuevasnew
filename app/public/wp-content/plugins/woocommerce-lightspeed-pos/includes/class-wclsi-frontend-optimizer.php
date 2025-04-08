<?php
/**
 * Class WCLSI_Frontend_Optimizer
 * Handles front-end optimizations and caching
 */
class WCLSI_Frontend_Optimizer {
    private const CACHE_PREFIX = 'wclsi_frontend_';
    private const CACHE_EXPIRY = 3600; // 1 hour
    private const ASSET_VERSION = '1.0.0';
    private const LAZY_LOAD_THRESHOLD = 3; // Number of images to load immediately

    private WCLSI_Api_Cache $cache;
    private array $optimization_settings = [];

    /**
     * Initialize the frontend optimizer
     * @param WCLSI_Api_Cache $cache Cache instance
     */
    public function __construct(WCLSI_Api_Cache $cache) {
        $this->cache = $cache;
        $this->load_settings();
        $this->setup_hooks();
    }

    /**
     * Load optimization settings
     */
    private function load_settings(): void {
        $this->optimization_settings = get_option('wclsi_optimization_settings', [
            'enable_lazy_loading' => true,
            'enable_image_optimization' => true,
            'enable_asset_minification' => true,
            'enable_browser_caching' => true,
            'enable_critical_css' => true,
            'enable_deferred_js' => true
        ]);
    }

    /**
     * Setup WordPress hooks
     */
    private function setup_hooks(): void {
        add_action('wp_enqueue_scripts', [$this, 'optimize_assets']);
        add_action('wp_head', [$this, 'add_critical_css']);
        add_filter('wp_get_attachment_image_attributes', [$this, 'optimize_image_attributes'], 10, 2);
        add_action('wp_footer', [$this, 'add_deferred_scripts']);
    }

    /**
     * Optimize frontend assets
     */
    public function optimize_assets(): void {
        if ($this->optimization_settings['enable_asset_minification']) {
            $this->minify_assets();
        }

        if ($this->optimization_settings['enable_browser_caching']) {
            $this->set_browser_caching_headers();
        }
    }

    /**
     * Minify CSS and JavaScript assets
     */
    private function minify_assets(): void {
        // Minify CSS
        wp_enqueue_style(
            'wclsi-styles',
            plugins_url('assets/css/wclsi.min.css', dirname(__FILE__)),
            [],
            self::ASSET_VERSION
        );

        // Minify JavaScript
        wp_enqueue_script(
            'wclsi-scripts',
            plugins_url('assets/js/wclsi.min.js', dirname(__FILE__)),
            ['jquery'],
            self::ASSET_VERSION,
            true
        );
    }

    /**
     * Set browser caching headers
     */
    private function set_browser_caching_headers(): void {
        if (!headers_sent()) {
            header('Cache-Control: public, max-age=' . self::CACHE_EXPIRY);
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + self::CACHE_EXPIRY) . ' GMT');
        }
    }

    /**
     * Add critical CSS to head
     */
    public function add_critical_css(): void {
        if (!$this->optimization_settings['enable_critical_css']) {
            return;
        }

        $critical_css = $this->cache->get(self::CACHE_PREFIX . 'critical_css');
        if (!$critical_css) {
            $critical_css = $this->generate_critical_css();
            $this->cache->set(self::CACHE_PREFIX . 'critical_css', $critical_css, self::CACHE_EXPIRY);
        }

        echo '<style>' . $critical_css . '</style>';
    }

    /**
     * Generate critical CSS
     * @return string Critical CSS
     */
    private function generate_critical_css(): string {
        // Implementation for generating critical CSS
        // This would extract and inline the most important CSS rules
        return '';
    }

    /**
     * Optimize image attributes for lazy loading
     * @param array $attributes Image attributes
     * @param WP_Post $attachment Attachment object
     * @return array Modified attributes
     */
    public function optimize_image_attributes(array $attributes, WP_Post $attachment): array {
        if (!$this->optimization_settings['enable_lazy_loading']) {
            return $attributes;
        }

        static $image_count = 0;
        $image_count++;

        if ($image_count > self::LAZY_LOAD_THRESHOLD) {
            $attributes['loading'] = 'lazy';
            $attributes['data-src'] = $attributes['src'];
            $attributes['src'] = $this->get_placeholder_image();
        }

        if ($this->optimization_settings['enable_image_optimization']) {
            $attributes['srcset'] = $this->optimize_image_srcset($attributes['srcset'] ?? '');
        }

        return $attributes;
    }

    /**
     * Get placeholder image
     * @return string Placeholder image URL
     */
    private function get_placeholder_image(): string {
        return 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="1" height="1" viewBox="0 0 1 1"></svg>');
    }

    /**
     * Optimize image srcset
     * @param string $srcset Image srcset
     * @return string Optimized srcset
     */
    private function optimize_image_srcset(string $srcset): string {
        // Implementation for optimizing image srcset
        // This would ensure appropriate image sizes are used
        return $srcset;
    }

    /**
     * Add deferred JavaScript
     */
    public function add_deferred_scripts(): void {
        if (!$this->optimization_settings['enable_deferred_js']) {
            return;
        }

        // Implementation for deferring non-critical JavaScript
        // This would move non-critical scripts to the footer
    }

    /**
     * Clear frontend cache
     */
    public function clear_cache(): void {
        $this->cache->delete(self::CACHE_PREFIX . 'critical_css');
        // Add more cache clearing as needed
    }

    /**
     * Get optimization settings
     * @return array Settings
     */
    public function get_settings(): array {
        return $this->optimization_settings;
    }

    /**
     * Update optimization settings
     * @param array $settings New settings
     */
    public function update_settings(array $settings): void {
        $this->optimization_settings = array_merge($this->optimization_settings, $settings);
        update_option('wclsi_optimization_settings', $this->optimization_settings);
    }
} 