<?php
/**
 * Template part for displaying featured products on the homepage
 *
 * @package Cuevas_Western_Wear
 */

// Only display if WooCommerce is active
if (!class_exists('WooCommerce')) {
    return;
}

$section_title = get_theme_mod('cuevas_featured_products_title', 'Featured Products');
$section_subtitle = get_theme_mod('cuevas_featured_products_subtitle', 'Discover our selection of premium Western wear');

// Get up to 6 featured products
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => 6,
    'tax_query'      => array(
        array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'featured',
        ),
    ),
);

$featured_products = new WP_Query($args);

// If we don't have enough featured products, get popular products
if ($featured_products->post_count < 6) {
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 6 - $featured_products->post_count,
        'meta_key'       => 'total_sales',
        'orderby'        => 'meta_value_num',
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'NOT IN',
            ),
        ),
    );
    
    $popular_products = new WP_Query($args);
    
    // Merge the queries
    $merged_products = array_merge($featured_products->posts, $popular_products->posts);
} else {
    $merged_products = $featured_products->posts;
}

// Only proceed if we have products
if (!empty($merged_products)) :
?>

<section id="featured-products" class="homepage-section featured-products-section">
    <div class="section-header">
        <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
        <p class="section-subtitle"><?php echo esc_html($section_subtitle); ?></p>
    </div>
    
    <div class="products-grid">
        <?php 
        foreach ($merged_products as $product) : 
            setup_postdata($GLOBALS['post'] = $product);
            $product_obj = wc_get_product($product->ID);
            
            if (!$product_obj) continue;
        ?>
            <div class="product-card">
                <a href="<?php echo esc_url(get_permalink($product->ID)); ?>" class="product-link">
                    <div class="product-image">
                        <?php echo $product_obj->get_image('medium'); ?>
                    </div>
                    <h3 class="product-title"><?php echo esc_html(get_the_title($product->ID)); ?></h3>
                    <div class="product-price">
                        <?php echo $product_obj->get_price_html(); ?>
                    </div>
                </a>
                <div class="product-add-to-cart">
                    <?php woocommerce_template_loop_add_to_cart(); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div class="section-footer">
        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="view-all-button">
            View All Products
        </a>
    </div>
</section><!-- #featured-products -->

<?php 
wp_reset_postdata();
endif;
?> 