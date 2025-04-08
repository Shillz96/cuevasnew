<?php
/**
 * Template part for displaying a full-screen 2x4 product grid
 *
 * @package Cuevas_Western_Wear
 */

// Only display if WooCommerce is active
if (!class_exists('WooCommerce')) {
    return;
}

// Get featured products or fallback to recent products
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => 8, // Fetch exactly 8 products for a 2x4 grid
    'status'         => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
);

// Try fetching featured products first
if (function_exists('wc_get_featured_product_ids')) {
    $featured_ids = wc_get_featured_product_ids();
    if (!empty($featured_ids)) {
        $args['post__in'] = array_slice($featured_ids, 0, 8); // Get up to 8 featured
        unset($args['orderby']); // Order by post__in default
    } else {
        // If no featured, just get recent 8
        $args['meta_query'] = array(); // Ensure meta query doesn't interfere if changed later
    }
} else {
    // Fallback if wc function doesn't exist
    $args['meta_query'] = array();
}

$products = new WP_Query($args);

// Only proceed if we have products
if ($products->have_posts()) :
?>

<section id="product-grid-section" class="homepage-section product-grid-section" data-section-name="featured-products">
    <div class="product-grid">
        <?php 
        while ($products->have_posts()) : $products->the_post();
            global $product;
            
            // Skip if not a valid product
            if (!is_a($product, 'WC_Product')) continue;
        ?>
            <div class="product-card">
                <a href="<?php the_permalink(); ?>" class="product-link">
                    <div class="product-image-container">
                        <?php echo woocommerce_get_product_thumbnail('woocommerce_thumbnail'); ?>
                        <?php if ($product->is_on_sale()) : ?>
                            <div class="product-badge badge-sale"><?php _e('Sale', 'cuevas-theme'); ?></div>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</section><!-- #product-grid-section -->

<?php 
wp_reset_postdata();
endif;
?> 