<?php
/**
 * Class WCLSI_GSAP_Optimizer
 * Handles GSAP optimizations while maintaining animation compatibility
 */
class WCLSI_GSAP_Optimizer {
    private const GSAP_VERSION = '3.12.5';
    private const SCROLL_TRIGGER_VERSION = '3.12.5';
    private const DEFERRED_ANIMATIONS = true;
    private const ANIMATION_THRESHOLD = 0.1; // Intersection Observer threshold

    private array $animation_elements = [];
    private array $gsap_settings = [];

    /**
     * Initialize the GSAP optimizer
     */
    public function __construct() {
        $this->load_settings();
        $this->setup_hooks();
    }

    /**
     * Load GSAP settings
     */
    private function load_settings(): void {
        $this->gsap_settings = get_option('wclsi_gsap_settings', [
            'enable_gsap' => true,
            'enable_scroll_trigger' => true,
            'enable_deferred_animations' => true,
            'enable_performance_mode' => true,
            'enable_animation_caching' => true
        ]);
    }

    /**
     * Setup WordPress hooks
     */
    private function setup_hooks(): void {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_gsap_scripts']);
        add_action('wp_footer', [$this, 'add_animation_initialization']);
        add_filter('wclsi_frontend_optimizer_deferred_scripts', [$this, 'handle_gsap_scripts']);
    }

    /**
     * Enqueue GSAP scripts
     */
    public function enqueue_gsap_scripts(): void {
        if (!$this->gsap_settings['enable_gsap']) {
            return;
        }

        // Enqueue GSAP core
        wp_enqueue_script(
            'gsap-core',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/' . self::GSAP_VERSION . '/gsap.min.js',
            [],
            self::GSAP_VERSION,
            true
        );

        // Enqueue ScrollTrigger if enabled
        if ($this->gsap_settings['enable_scroll_trigger']) {
            wp_enqueue_script(
                'gsap-scroll-trigger',
                'https://cdnjs.cloudflare.com/ajax/libs/gsap/' . self::SCROLL_TRIGGER_VERSION . '/ScrollTrigger.min.js',
                ['gsap-core'],
                self::SCROLL_TRIGGER_VERSION,
                true
            );
        }

        // Add GSAP initialization script
        wp_add_inline_script('gsap-core', $this->get_gsap_initialization_script());
    }

    /**
     * Handle GSAP scripts in deferred loading
     * @param array $scripts Scripts to defer
     * @return array Modified scripts
     */
    public function handle_gsap_scripts(array $scripts): array {
        if ($this->gsap_settings['enable_deferred_animations']) {
            $scripts[] = 'gsap-core';
            if ($this->gsap_settings['enable_scroll_trigger']) {
                $scripts[] = 'gsap-scroll-trigger';
            }
        }
        return $scripts;
    }

    /**
     * Get GSAP initialization script
     * @return string Initialization script
     */
    private function get_gsap_initialization_script(): string {
        return "
            window.WCLSI_GSAP = {
                settings: " . wp_json_encode($this->gsap_settings) . ",
                elements: " . wp_json_encode($this->animation_elements) . ",
                init: function() {
                    if (this.settings.enable_performance_mode) {
                        gsap.config({
                            nullTargetWarn: false,
                            force3D: true
                        });
                    }
                    
                    if (this.settings.enable_deferred_animations) {
                        this.initializeDeferredAnimations();
                    }
                },
                initializeDeferredAnimations: function() {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                this.animateElement(entry.target);
                                observer.unobserve(entry.target);
                            }
                        });
                    }, {
                        threshold: " . self::ANIMATION_THRESHOLD . "
                    });

                    document.querySelectorAll('[data-gsap-animation]').forEach(el => {
                        observer.observe(el);
                    });
                },
                animateElement: function(element) {
                    const animation = element.dataset.gsapAnimation;
                    if (animation) {
                        try {
                            const config = JSON.parse(animation);
                            gsap.to(element, config);
                        } catch (e) {
                            console.error('GSAP animation error:', e);
                        }
                    }
                }
            };

            document.addEventListener('DOMContentLoaded', function() {
                window.WCLSI_GSAP.init();
            });
        ";
    }

    /**
     * Add animation initialization
     */
    public function add_animation_initialization(): void {
        if (!$this->gsap_settings['enable_gsap']) {
            return;
        }

        echo '<script type="text/javascript">';
        echo $this->get_gsap_initialization_script();
        echo '</script>';
    }

    /**
     * Register animation element
     * @param string $selector Element selector
     * @param array $animation Animation configuration
     */
    public function register_animation(string $selector, array $animation): void {
        $this->animation_elements[$selector] = $animation;
    }

    /**
     * Get GSAP settings
     * @return array Settings
     */
    public function get_settings(): array {
        return $this->gsap_settings;
    }

    /**
     * Update GSAP settings
     * @param array $settings New settings
     */
    public function update_settings(array $settings): void {
        $this->gsap_settings = array_merge($this->gsap_settings, $settings);
        update_option('wclsi_gsap_settings', $this->gsap_settings);
    }
} 