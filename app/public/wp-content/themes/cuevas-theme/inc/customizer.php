<?php
/**
 * Cuevas Western Wear Theme Customizer
 *
 * @package Cuevas_Western_Wear
 */

if ( ! function_exists( 'cuevas_customize_register' ) ) : /** Add function_exists check */
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function cuevas_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	// Add Homepage Sections Panel
	$wp_customize->add_panel( 'cuevas_homepage_panel', array(
		'title'       => __( 'Homepage Sections', 'cuevas' ),
		'description' => __( 'Customize the homepage sections', 'cuevas' ),
		'priority'    => 130,
	) );
	
	// Hero Section
	$wp_customize->add_section( 'cuevas_hero_section', array(
		'title'       => __( 'Hero Section', 'cuevas' ),
		'description' => __( 'Customize the hero section on the homepage', 'cuevas' ),
		'panel'       => 'cuevas_homepage_panel',
		'priority'    => 10,
	) );
	
	// Hero Image
	$wp_customize->add_setting( 'cuevas_hero_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cuevas_hero_image', array(
		'label'       => __( 'Hero Background Image', 'cuevas' ),
		'description' => __( 'Upload an image for the hero section background', 'cuevas' ),
		'section'     => 'cuevas_hero_section',
		'settings'    => 'cuevas_hero_image',
	) ) );
	
	// Hero Title
	$wp_customize->add_setting( 'cuevas_hero_title', array(
		'default'           => 'Cuevas Western Wear',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'cuevas_hero_title', array(
		'label'       => __( 'Hero Title', 'cuevas' ),
		'description' => __( 'Enter the title for the hero section', 'cuevas' ),
		'section'     => 'cuevas_hero_section',
		'type'        => 'text',
	) );
	
	// Hero Subtitle
	$wp_customize->add_setting( 'cuevas_hero_subtitle', array(
		'default'           => 'Authentic Western Style',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'cuevas_hero_subtitle', array(
		'label'       => __( 'Hero Subtitle', 'cuevas' ),
		'description' => __( 'Enter the subtitle for the hero section', 'cuevas' ),
		'section'     => 'cuevas_hero_section',
		'type'        => 'text',
	) );
	
	// Hero Button Text
	$wp_customize->add_setting( 'cuevas_hero_button_text', array(
		'default'           => 'Shop Now',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'cuevas_hero_button_text', array(
		'label'       => __( 'Button Text', 'cuevas' ),
		'description' => __( 'Enter the text for the hero button', 'cuevas' ),
		'section'     => 'cuevas_hero_section',
		'type'        => 'text',
	) );
	
	// Hero Button URL
	$wp_customize->add_setting( 'cuevas_hero_button_url', array(
		'default'           => '#shop-categories',
		'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control( 'cuevas_hero_button_url', array(
		'label'       => __( 'Button URL', 'cuevas' ),
		'description' => __( 'Enter the URL for the hero button', 'cuevas' ),
		'section'     => 'cuevas_hero_section',
		'type'        => 'url',
	) );
	
	// Gallery Section (Split Slideshow)
	$wp_customize->add_section( 'cuevas_gallery_section', array(
		'title'       => __( 'Gallery Section', 'cuevas' ),
		'description' => __( 'Customize the gallery slideshow on the homepage', 'cuevas' ),
		'panel'       => 'cuevas_homepage_panel',
		'priority'    => 15,
	) );
    
    // Gallery Slide 1
    $wp_customize->add_setting( 'cuevas_gallery_image_1', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cuevas_gallery_image_1', array(
        'label'       => __( 'Gallery Image 1', 'cuevas' ),
        'description' => __( 'Upload image for gallery slide 1', 'cuevas' ),
        'section'     => 'cuevas_gallery_section',
    ) ) );
    
    $wp_customize->add_setting( 'cuevas_gallery_text_1', array(
        'default'           => 'Authentic',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'cuevas_gallery_text_1', array(
        'label'       => __( 'Gallery Text 1', 'cuevas' ),
        'description' => __( 'Text for gallery slide 1', 'cuevas' ),
        'section'     => 'cuevas_gallery_section',
        'type'        => 'text',
    ) );
    
    // Gallery Slide 2
    $wp_customize->add_setting( 'cuevas_gallery_image_2', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cuevas_gallery_image_2', array(
        'label'       => __( 'Gallery Image 2', 'cuevas' ),
        'description' => __( 'Upload image for gallery slide 2', 'cuevas' ),
        'section'     => 'cuevas_gallery_section',
    ) ) );
    
    $wp_customize->add_setting( 'cuevas_gallery_text_2', array(
        'default'           => 'Western',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'cuevas_gallery_text_2', array(
        'label'       => __( 'Gallery Text 2', 'cuevas' ),
        'description' => __( 'Text for gallery slide 2', 'cuevas' ),
        'section'     => 'cuevas_gallery_section',
        'type'        => 'text',
    ) );
    
    // Gallery Slide 3
    $wp_customize->add_setting( 'cuevas_gallery_image_3', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cuevas_gallery_image_3', array(
        'label'       => __( 'Gallery Image 3', 'cuevas' ),
        'description' => __( 'Upload image for gallery slide 3', 'cuevas' ),
        'section'     => 'cuevas_gallery_section',
    ) ) );
    
    $wp_customize->add_setting( 'cuevas_gallery_text_3', array(
        'default'           => 'Heritage',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'cuevas_gallery_text_3', array(
        'label'       => __( 'Gallery Text 3', 'cuevas' ),
        'description' => __( 'Text for gallery slide 3', 'cuevas' ),
        'section'     => 'cuevas_gallery_section',
        'type'        => 'text',
    ) );
    
    // Gallery Slide 4
    $wp_customize->add_setting( 'cuevas_gallery_image_4', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cuevas_gallery_image_4', array(
        'label'       => __( 'Gallery Image 4', 'cuevas' ),
        'description' => __( 'Upload image for gallery slide 4', 'cuevas' ),
        'section'     => 'cuevas_gallery_section',
    ) ) );
    
    $wp_customize->add_setting( 'cuevas_gallery_text_4', array(
        'default'           => 'Tradition',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'cuevas_gallery_text_4', array(
        'label'       => __( 'Gallery Text 4', 'cuevas' ),
        'description' => __( 'Text for gallery slide 4', 'cuevas' ),
        'section'     => 'cuevas_gallery_section',
        'type'        => 'text',
    ) );
	
	// Featured Products Section
	$wp_customize->add_section( 'cuevas_featured_products_section', array(
		'title'       => __( 'Featured Products Section', 'cuevas' ),
		'description' => __( 'Customize the featured products section on the homepage', 'cuevas' ),
		'panel'       => 'cuevas_homepage_panel',
		'priority'    => 20,
	) );
	
	// Featured Products Title
	$wp_customize->add_setting( 'cuevas_featured_products_title', array(
		'default'           => 'Featured Products',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'cuevas_featured_products_title', array(
		'label'       => __( 'Section Title', 'cuevas' ),
		'description' => __( 'Enter the title for the featured products section', 'cuevas' ),
		'section'     => 'cuevas_featured_products_section',
		'type'        => 'text',
	) );
	
	// Featured Products Subtitle
	$wp_customize->add_setting( 'cuevas_featured_products_subtitle', array(
		'default'           => 'Discover our selection of premium Western wear',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'cuevas_featured_products_subtitle', array(
		'label'       => __( 'Section Subtitle', 'cuevas' ),
		'description' => __( 'Enter the subtitle for the featured products section', 'cuevas' ),
		'section'     => 'cuevas_featured_products_section',
		'type'        => 'text',
	) );
	
	// Shop Categories Section
	$wp_customize->add_section( 'cuevas_shop_categories_section', array(
		'title'       => __( 'Shop Categories Section', 'cuevas' ),
		'description' => __( 'Customize the shop categories section on the homepage', 'cuevas' ),
		'panel'       => 'cuevas_homepage_panel',
		'priority'    => 30,
	) );
	
	// Shop Categories Title
	$wp_customize->add_setting( 'cuevas_shop_categories_title', array(
		'default'           => 'Shop Categories',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'cuevas_shop_categories_title', array(
		'label'       => __( 'Section Title', 'cuevas' ),
		'description' => __( 'Enter the title for the shop categories section', 'cuevas' ),
		'section'     => 'cuevas_shop_categories_section',
		'type'        => 'text',
	) );
	
	// Shop Categories Subtitle
	$wp_customize->add_setting( 'cuevas_shop_categories_subtitle', array(
		'default'           => 'Browse our Western collections',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'cuevas_shop_categories_subtitle', array(
		'label'       => __( 'Section Subtitle', 'cuevas' ),
		'description' => __( 'Enter the subtitle for the shop categories section', 'cuevas' ),
		'section'     => 'cuevas_shop_categories_section',
		'type'        => 'text',
	) );

	// Background Image
	$wp_customize->add_setting( 'cuevas_shop_categories_bg_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cuevas_shop_categories_bg_image', array(
		'label'       => __( 'Background Image', 'cuevas' ),
		'description' => __( 'Upload a background image for the shop categories section', 'cuevas' ),
		'section'     => 'cuevas_shop_categories_section',
		'settings'    => 'cuevas_shop_categories_bg_image',
	) ) );

	// CTA 1 Title
	$wp_customize->add_setting( 'cuevas_shop_cta1_title', array(
		'default'           => 'Boots',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'cuevas_shop_cta1_title', array(
		'label'       => __( 'First CTA Button Title', 'cuevas' ),
		'section'     => 'cuevas_shop_categories_section',
		'type'        => 'text',
	) );
	
	// CTA 1 URL
	$wp_customize->add_setting( 'cuevas_shop_cta1_url', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control( 'cuevas_shop_cta1_url', array(
		'label'       => __( 'First CTA Button URL', 'cuevas' ),
		'section'     => 'cuevas_shop_categories_section',
		'type'        => 'url',
	) );

	// CTA 2 Title
	$wp_customize->add_setting( 'cuevas_shop_cta2_title', array(
		'default'           => 'Hats',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'cuevas_shop_cta2_title', array(
		'label'       => __( 'Second CTA Button Title', 'cuevas' ),
		'section'     => 'cuevas_shop_categories_section',
		'type'        => 'text',
	) );
	
	// CTA 2 URL
	$wp_customize->add_setting( 'cuevas_shop_cta2_url', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control( 'cuevas_shop_cta2_url', array(
		'label'       => __( 'Second CTA Button URL', 'cuevas' ),
		'section'     => 'cuevas_shop_categories_section',
		'type'        => 'url',
	) );

	// CTA 3 Title
	$wp_customize->add_setting( 'cuevas_shop_cta3_title', array(
		'default'           => 'Clothing',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'cuevas_shop_cta3_title', array(
		'label'       => __( 'Third CTA Button Title', 'cuevas' ),
		'section'     => 'cuevas_shop_categories_section',
		'type'        => 'text',
	) );
	
	// CTA 3 URL
	$wp_customize->add_setting( 'cuevas_shop_cta3_url', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control( 'cuevas_shop_cta3_url', array(
		'label'       => __( 'Third CTA Button URL', 'cuevas' ),
		'section'     => 'cuevas_shop_categories_section',
		'type'        => 'url',
	) );
	
	// Add Navigation Appearance Section
	$wp_customize->add_section( 'cuevas_navigation_section', array(
		'title'       => __( 'Navigation', 'cuevas' ),
		'description' => __( 'Customize the main navigation', 'cuevas' ),
		'priority'    => 120,
	) );
	
	// Nav Background Color
	$wp_customize->add_setting( 'cuevas_nav_bg_color', array(
		'default'           => '#3E2723', // Dark brown 
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cuevas_nav_bg_color', array(
		'label'       => __( 'Navigation Background Color', 'cuevas' ),
		'description' => __( 'Background color for the navigation bar', 'cuevas' ),
		'section'     => 'cuevas_navigation_section',
	) ) );
	
	// Nav Text Color
	$wp_customize->add_setting( 'cuevas_nav_text_color', array(
		'default'           => '#FFFFFF', // White
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cuevas_nav_text_color', array(
		'label'       => __( 'Navigation Text Color', 'cuevas' ),
		'description' => __( 'Text color for the navigation bar', 'cuevas' ),
		'section'     => 'cuevas_navigation_section',
	) ) );
	
	// Add Footer Settings Section
	$wp_customize->add_section( 'cuevas_footer_section', array(
		'title'       => __( 'Footer Settings', 'cuevas' ),
		'description' => __( 'Customize the footer content and social links', 'cuevas' ),
		'priority'    => 140, // After Homepage and Navigation
	) );

	// Footer About Text
	$wp_customize->add_setting( 'cuevas_footer_about', array(
		'default'           => 'Family-owned and operated since 1985, bringing quality western wear to our community for generations.',
		'sanitize_callback' => 'wp_kses_post', // Allow basic HTML
	) );

	$wp_customize->add_control( 'cuevas_footer_about', array(
		'label'       => __( 'Footer About Text', 'cuevas' ),
		'section'     => 'cuevas_footer_section',
		'type'        => 'textarea',
	) );

	// Footer Contact Address
	$wp_customize->add_setting( 'cuevas_footer_address', array(
		'default'           => "123 Western Avenue\nSan Antonio, TX 12345",
		'sanitize_callback' => 'wp_kses_post', // Allow line breaks
	) );

	$wp_customize->add_control( 'cuevas_footer_address', array(
		'label'       => __( 'Contact Address', 'cuevas' ),
		'section'     => 'cuevas_footer_section',
		'type'        => 'textarea',
	) );

	// Footer Contact Phone
	$wp_customize->add_setting( 'cuevas_footer_phone', array(
		'default'           => '(123) 456-7890',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'cuevas_footer_phone', array(
		'label'       => __( 'Contact Phone', 'cuevas' ),
		'section'     => 'cuevas_footer_section',
		'type'        => 'text',
	) );

	// Footer Contact Email
	$wp_customize->add_setting( 'cuevas_footer_email', array(
		'default'           => 'info@cuevaswestern.com',
		'sanitize_callback' => 'sanitize_email',
	) );

	$wp_customize->add_control( 'cuevas_footer_email', array(
		'label'       => __( 'Contact Email', 'cuevas' ),
		'section'     => 'cuevas_footer_section',
		'type'        => 'email',
	) );

	// Social Links
	$social_networks = array('facebook', 'instagram', 'twitter', 'pinterest');
	foreach ($social_networks as $network) {
		$wp_customize->add_setting( "cuevas_social_{$network}", array(
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_control( "cuevas_social_{$network}", array(
			'label'       => sprintf(__( '%s URL', 'cuevas' ), ucfirst($network)),
			'section'     => 'cuevas_footer_section',
			'type'        => 'url',
		) );
	}
}
add_action( 'customize_register', 'cuevas_customize_register' );
endif; /** End function_exists check */

/**
 * Sanitize checkbox values
 */
if ( ! function_exists( 'cuevas_sanitize_checkbox' ) ) {
    function cuevas_sanitize_checkbox( $checked ) {
        return ( isset( $checked ) && true == $checked ) ? true : false;
    }
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
if ( ! function_exists( 'cuevas_customize_preview_js' ) ) {
    function cuevas_customize_preview_js() {
    	wp_enqueue_script( 'cuevas-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), CUEVAS_VERSION, true );
    }
    add_action( 'customize_preview_init', 'cuevas_customize_preview_js' ); 
} 