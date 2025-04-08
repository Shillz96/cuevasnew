<?php
/**
 * Template part for displaying the shop categories section on the homepage
 *
 * @package Cuevas_Western_Wear
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get theme customizer setting with fallback to default value
 * 
 * @param string $setting_name The theme mod setting name
 * @param mixed $default The default value if setting is not found
 * @return mixed The setting value or default
 */
function get_shop_category_setting($setting_name, $default = '') {
    $value = get_theme_mod($setting_name, $default);
    
    if (defined('WP_DEBUG') && WP_DEBUG && function_exists('cuevas_debug_log')) {
        cuevas_debug_log("Shop category setting {$setting_name}: " . print_r($value, true));
    }
    
    return $value;
}

// Section text content
$section_title = get_shop_category_setting('cuevas_shop_categories_title', 'Shop Categories');
$section_subtitle = get_shop_category_setting('cuevas_shop_categories_subtitle', 'Find your style in our collections');

// Background image
$raw_bg_image_setting = get_theme_mod('cuevas_shop_categories_bg_image'); // Get raw value for debugging
$background_image = get_shop_category_setting('cuevas_shop_categories_bg_image', '');
if (empty($background_image)) {
    $background_image = get_template_directory_uri() . '/assets/images/shop-categories-bg.jpg';
}

// Get category data from theme customizer
$categories = [
    [
        'name' => get_shop_category_setting('cuevas_shop_cta1_title', 'Boots'),
        'link' => get_shop_category_setting('cuevas_shop_cta1_url', '/product-category/boots/'),
        'icon' => 'boot'
    ],
    [
        'name' => get_shop_category_setting('cuevas_shop_cta2_title', 'Hats'),
        'link' => get_shop_category_setting('cuevas_shop_cta2_url', '/product-category/hats/'),
        'icon' => 'hat'
    ],
    [
        'name' => get_shop_category_setting('cuevas_shop_cta3_title', 'Clothing'),
        'link' => get_shop_category_setting('cuevas_shop_cta3_url', '/product-category/clothing/'),
        'icon' => 'tshirt'
    ],
    [
        'name' => 'Accessories',
        'link' => '/product-category/accessories/',
        'icon' => 'accessory'
    ]
];
?>

<!-- DEBUG: Raw BG Image Setting: <?php echo esc_html(print_r($raw_bg_image_setting, true)); ?> -->
<section id="shop-categories" class="shop-categories-section homepage-section" data-section-name="shop-now">
    <div class="section-background" style="background-image: url('<?php echo esc_url($background_image); ?>');">
        <div class="overlay"></div>
    </div>
    
    <div class="section-content container">
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
            <p class="section-subtitle"><?php echo esc_html($section_subtitle); ?></p>
        </div>
        
        <div class="cta-buttons-container">
            <?php foreach ($categories as $category) : ?>
            <a href="<?php echo esc_url($category['link']); ?>" class="cta-button btn <?php echo esc_attr($category['icon']); ?>-button">
                <span class="category-name"><?php echo esc_html($category['name']); ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
