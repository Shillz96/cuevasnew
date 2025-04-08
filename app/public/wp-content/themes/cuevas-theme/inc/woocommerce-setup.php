<?php
/**
 * WooCommerce setup and customization
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Fix product visibility in catalog
 */
function cuevas_fix_product_visibility() {
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );
    
    $products = get_posts($args);
    
    foreach ($products as $product) {
        update_post_meta($product->ID, '_visibility', 'visible');
        update_post_meta($product->ID, '_catalog_visibility', 'visible');
    }
}
add_action('init', 'cuevas_fix_product_visibility'); 