<?php
/**
 * Cuevas Western Wear Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Cuevas_Western_Wear
 */

if ( ! defined( 'CUEVAS_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'CUEVAS_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function cuevas_theme_setup() {
	/*
	 * Make theme available for translation.
	 */
	load_theme_textdomain( 'cuevas', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in multiple locations.
	register_nav_menus(
		array(
			'primary-menu' => esc_html__( 'Primary Menu', 'cuevas' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'cuevas' ),
		)
	);

	/*
	 * Switch default core markup to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'cuevas_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo. Enable logo upload in Customizer.
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 100, // Optional: Suggest height
			'width'       => 300, // Optional: Suggest width
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// WooCommerce support
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'cuevas_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cuevas_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cuevas_content_width', 1200 );
}
add_action( 'after_setup_theme', 'cuevas_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cuevas_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Main Sidebar', 'cuevas' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'cuevas' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>', // Added span for potential styling
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets', 'cuevas' ),
		'id'            => 'footer-sidebar', // ID used in footer.php
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'cuevas' ),
		'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title footer-title">', // Different heading level for footer
		'after_title'   => '</h3>',
	) );

	// Add Shop Sidebar if needed
	// register_sidebar( array( ... 'id' => 'sidebar-shop' ... ) );
}
add_action( 'widgets_init', 'cuevas_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function cuevas_scripts() {
	// Main stylesheet
	// wp_enqueue_style( 'cuevas-style', get_stylesheet_uri(), array(), CUEVAS_VERSION ); // Keep main.css primary for now
	wp_enqueue_style( 'cuevas-main', get_template_directory_uri() . '/assets/css/main.css', array(), CUEVAS_VERSION );
	
	// Uncomment necessary styles/scripts

	// Load WooCommerce styles if WooCommerce is active and file exists
	if (class_exists('WooCommerce')) {
		$woo_css_path = get_template_directory() . '/assets/css/woocommerce.css';
		if (file_exists($woo_css_path)) {
			wp_enqueue_style('cuevas-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array('cuevas-main'), filemtime($woo_css_path));
		}
	}

	// Load product card CSS if file exists (General card styles)
	$product_card_css_path = get_template_directory() . '/assets/css/product-card.css';
	if (file_exists($product_card_css_path)) {
		wp_enqueue_style('cuevas-product-card', get_template_directory_uri() . '/assets/css/product-card.css', array('cuevas-main'), filemtime($product_card_css_path));
	}

	// Load product grid CSS if file exists (Specific grid layouts, depends on card styles)
	$product_grid_css_path = get_template_directory() . '/assets/css/product-grid.css';
	if (file_exists($product_grid_css_path)) {
		// Make grid depend on card styles
		wp_enqueue_style('cuevas-product-grid', get_template_directory_uri() . '/assets/css/product-grid.css', array('cuevas-product-card'), filemtime($product_grid_css_path)); 
	}

	// Load product page CSS if on a product page and file exists
	if (function_exists('is_product') && is_product()) {
		$product_css_path = get_template_directory() . '/assets/css/product-page.css';
		if (file_exists($product_css_path)) {
			wp_enqueue_style('cuevas-product-page-css', get_template_directory_uri() . '/assets/css/product-page.css', array('cuevas-main'), filemtime($product_css_path));
		}
	}

	// Google Fonts
	// Remove Raleway if it was enqueued here
	// Example: wp_dequeue_style( 'cuevas-raleway-font' ); 

	// Enqueue Cinzel
	wp_enqueue_style( 'cuevas-cinzel-font', 'https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap', array(), null );

	// Enqueue main stylesheet
	wp_enqueue_style( 'cuevas-style', get_stylesheet_directory_uri() . '/assets/css/main.css', array(), filemtime( get_template_directory() . '/assets/css/main.css' ) );

	// Make sure jQuery is loaded (it's a dependency for Slick and others)
	wp_enqueue_script('jquery');
	
	// Slick Slider (Needed for slideshow)
	wp_enqueue_style( 'slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1' );
	wp_enqueue_script( 'slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true );
	
	// GSAP for animations (Updated versions)
	wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '3.12.5', true );
	wp_enqueue_script( 'gsap-scroll-trigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array('gsap'), '3.12.5', true );
	wp_enqueue_script( 'gsap-scrollto', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollToPlugin.min.js', array('gsap'), '3.12.5', true );
	
	// Main navigation functionality
	wp_enqueue_script( 'cuevas-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array('jquery'), CUEVAS_VERSION, true ); // Added jquery dependency
	
	// Load custom site animations - depends on GSAP plugins
	wp_enqueue_script( 'cuevas-animations', get_template_directory_uri() . '/assets/js/animations.js', array('gsap', 'gsap-scroll-trigger', 'gsap-scrollto', 'jquery'), CUEVAS_VERSION, true ); // Added jquery dependency
	
	// Specific scripts for homepage
	if ( is_front_page() ) {
		// Homepage specific styles if files exist
		$slideshow_css_path = get_template_directory() . '/assets/css/split-slideshow.css';
		if (file_exists($slideshow_css_path)) {
			wp_enqueue_style( 'cuevas-slideshow', get_template_directory_uri() . '/assets/css/split-slideshow.css', array(), filemtime($slideshow_css_path) );
		}
		$homepage_css_path = get_template_directory() . '/assets/css/homepage.css';
		if (file_exists($homepage_css_path)) {
			wp_enqueue_style( 'cuevas-homepage', get_template_directory_uri() . '/assets/css/homepage.css', array(), filemtime($homepage_css_path) );
		}
		$shop_categories_css_path = get_template_directory() . '/assets/css/shop-categories.css';
		if (file_exists($shop_categories_css_path)) {
			wp_enqueue_style( 'cuevas-shop-categories', get_template_directory_uri() . '/assets/css/shop-categories.css', array(), filemtime($shop_categories_css_path) );
		}
		
		// Slideshow script (depends on slick and GSAP)
		wp_enqueue_script( 'cuevas-slideshow', get_template_directory_uri() . '/assets/js/split-slideshow.js', array('jquery', 'slick', 'gsap'), CUEVAS_VERSION, true );
	}
	
	// About page specific script if file exists
	if ( is_page_template('page-about.php') ) {
		$about_js_path = get_template_directory() . '/assets/js/about-animations.js';
		if(file_exists($about_js_path)) {
			wp_enqueue_script( 'cuevas-about', get_template_directory_uri() . '/assets/js/about-animations.js', array('gsap', 'gsap-scroll-trigger'), CUEVAS_VERSION, true );
		}
	}
	
	// WooCommerce product page script if file exists
	if ( function_exists('is_product') && is_product() ) {
		wp_enqueue_script( 'comment-reply' ); // Keep this for threaded comments
		$product_js_path = get_template_directory() . '/assets/js/product-page.js';
		if(file_exists($product_js_path)) {
			wp_enqueue_script( 'cuevas-product', get_template_directory_uri() . '/assets/js/product-page.js', array('jquery', 'slick'), CUEVAS_VERSION, true );
		}
	}

	// Comment reply script for threaded comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	// WooCommerce shop and cart page scripts and styles
	if ( function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag() || is_cart()) ) {
		$shop_js_path = get_template_directory() . '/assets/js/shop.js';
		if(file_exists($shop_js_path)) {
			wp_enqueue_script( 'cuevas-shop', get_template_directory_uri() . '/assets/js/shop.js', array('jquery'), CUEVAS_VERSION, true );
		}
	}

	// Load FAQ page script
	if (is_page_template('page-faq.php')) {
		wp_enqueue_script('cuevas-faq', get_template_directory_uri() . '/assets/js/faq.js', array('jquery'), CUEVAS_VERSION, true);
	}

	// Load Font Awesome icons
	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4' );
}
add_action( 'wp_enqueue_scripts', 'cuevas_scripts' );

/**
 * Include additional required files
 */
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/customizer.php';
// require get_template_directory() . '/inc/enqueue.php'; // Removed - redundant enqueue logic

// Check if WooCommerce is active
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

// Include WooCommerce setup
require get_template_directory() . '/inc/woocommerce-setup.php';

// Include WooCommerce reset
require_once get_template_directory() . '/inc/woocommerce-reset.php';

/**
 * Add debugging functionality
 */
if ( defined('WP_DEBUG') && WP_DEBUG ) {
    function cuevas_debug_log($message) {
        error_log('[Cuevas Theme] ' . $message);
        
        if (is_admin() || current_user_can('administrator')) {
            // Only show to admins
            echo '<script>console.log("[Cuevas Theme] ' . esc_js($message) . '");</script>';
        }
    }
}

/**
 * Debug template usage
 */
if ( defined('WP_DEBUG') && WP_DEBUG ) {
    function cuevas_debug_template() {
        global $template;
        if (function_exists('cuevas_debug_log')) { // Check if debug log function exists
            cuevas_debug_log('Template file: ' . basename($template));
            
            // Add detailed template hierarchy info
            $templates = array();
            
            if (is_front_page()) {
                $templates[] = 'front-page.php';
            }
            
            if (is_home()) {
                $templates[] = 'home.php';
            }
            
            if (is_singular()) {
                $templates[] = 'single-' . get_post_type() . '.php';
                $templates[] = 'singular.php';
                $templates[] = 'single.php';
            }
            
            if (is_page()) {
                $id = get_queried_object_id();
                $template_slug = get_page_template_slug(); // Renamed variable to avoid conflict
                $pagename = get_query_var('pagename');
                
                if ($template_slug) {
                    $templates[] = $template_slug;
                }
                
                if ($pagename) {
                    $templates[] = "page-$pagename.php";
                }
                
                $templates[] = "page-$id.php";
                $templates[] = 'page.php';
            }
            
            $templates[] = 'index.php';
            
            cuevas_debug_log('Template hierarchy: ' . implode(' → ', $templates));
        } // End check for cuevas_debug_log existence
    }
    add_action('wp_footer', 'cuevas_debug_template');
}

/**
 * WooCommerce specific setup.
 */
function cuevas_woocommerce_setup() {
    add_theme_support( 'woocommerce', array(
        // Ensure standard image sizes are supported. Adjust sizes if needed.
        'thumbnail_image_width' => 300, // Used in loops
        'single_image_width'    => 600, // Used on single product page

        // Optionally define custom aspect ratios if needed, e.g.:
        // 'product_grid' => array(
        //     'default_rows'    => 4,
        //     'min_rows'        => 2,
        //     'max_rows'        => 8,
        //     'default_columns' => 4,
        //     'min_columns'     => 2,
        //     'max_columns'     => 5,
        // ),
    ) );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'cuevas_woocommerce_setup' );

/**
 * Register Custom Image Sizes (if needed)
 */
// function cuevas_register_image_sizes() {
//     // Example: add_image_size( 'custom_gallery_thumbnail', 150, 150, true );
// }
// add_action( 'init', 'cuevas_register_image_sizes' );

/**
 * Check if WooCommerce is active and set up required pages
 */
function cuevas_check_woocommerce() {
    if (!class_exists('WooCommerce')) {
        return;
    }

    // Force refresh WooCommerce settings
    delete_option('woocommerce_shop_page_id');
    delete_option('woocommerce_cart_page_id');
    delete_option('woocommerce_checkout_page_id');
    delete_option('woocommerce_myaccount_page_id');
    delete_option('woocommerce_terms_page_id');

    // Create pages
    $pages = array(
        'shop' => array(
            'title' => 'Shop',
            'content' => ''
        ),
        'cart' => array(
            'title' => 'Cart',
            'content' => '[woocommerce_cart]'
        ),
        'checkout' => array(
            'title' => 'Checkout',
            'content' => '[woocommerce_checkout]'
        ),
        'my-account' => array(
            'title' => 'My Account',
            'content' => '[woocommerce_my_account]'
        )
    );

    foreach ($pages as $slug => $page) {
        $query = new WP_Query(array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'title' => $page['title']
        ));

        if (!$query->have_posts()) {
            $page_id = wp_insert_post(array(
                'post_title' => $page['title'],
                'post_content' => $page['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_name' => $slug
            ));

            if ($slug === 'shop') {
                update_option('woocommerce_shop_page_id', $page_id);
                update_option('woocommerce_enable_shop_page', 'yes');
            } elseif ($slug === 'cart') {
                update_option('woocommerce_cart_page_id', $page_id);
            } elseif ($slug === 'checkout') {
                update_option('woocommerce_checkout_page_id', $page_id);
            } elseif ($slug === 'my-account') {
                update_option('woocommerce_myaccount_page_id', $page_id);
            }
        }
    }

    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('init', 'cuevas_check_woocommerce', 0);

// == Globally Disable Comments ==
// Disable support for comments and trackbacks in post types
function cuevas_disable_comments_post_types_support() {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'cuevas_disable_comments_post_types_support');

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
function cuevas_disable_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'cuevas_disable_comments_admin_menu');

// Redirect any user trying to access comments page
function cuevas_disable_comments_admin_menu_redirect() {
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url()); exit;
    }
}
add_action('admin_init', 'cuevas_disable_comments_admin_menu_redirect');

// Remove comments metabox from dashboard
function cuevas_disable_comments_dashboard() {
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'cuevas_disable_comments_dashboard');

// Remove comments links from admin bar
function cuevas_disable_comments_admin_bar() {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
}
add_action('init', 'cuevas_disable_comments_admin_bar');
// == End Globally Disable Comments ==
