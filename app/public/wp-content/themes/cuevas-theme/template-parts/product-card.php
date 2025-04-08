<?php
/**
 * Template part for displaying a product card.
 *
 * This template part is intended to be used within WooCommerce template overrides,
 * particularly in content-product.php.
 *
 * @package Cuevas_Western_Wear
 */

global $product;

// Ensure visibility.
deif ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<div <?php wc_product_class( 'product-card', $product ); ?>>
  <div class="product-image-container">
    <?php
    /**
     * Hook: woocommerce_before_shop_loop_item_title.
     *
     * @hooked woocommerce_show_product_loop_sale_flash - 10
     * @hooked woocommerce_template_loop_product_thumbnail - 10
     */
    do_action( 'woocommerce_before_shop_loop_item_title' );
    ?>
    <?php /* Add Quick View button if functionality exists */ ?>
    <?php /* <div class="quick-view-btn"><?php esc_html_e('Quick View', 'cuevas'); ?></div> */ ?>
  </div>
  
  <div class="product-info">
    <?php
    /**
     * Hook: woocommerce_shop_loop_item_title.
     *
     * @hooked woocommerce_template_loop_product_title - 10
     */
    do_action( 'woocommerce_shop_loop_item_title' );
    ?>

    <?php if ( $product->get_short_description() ) : ?>
      <div class="product-subtitle woocommerce-product-details__short-description">
        <?php echo wp_trim_words( $product->get_short_description(), 10 ); ?>
      </div>
    <?php endif; ?>

    <?php
    /**
     * Hook: woocommerce_after_shop_loop_item_title.
     *
     * @hooked woocommerce_template_loop_rating - 5
     * @hooked woocommerce_template_loop_price - 10
     */
    do_action( 'woocommerce_after_shop_loop_item_title' );
    ?>

    <?php
    /**
     * Hook: woocommerce_after_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_close - 5
     * @hooked woocommerce_template_loop_add_to_cart - 10
     */
    do_action( 'woocommerce_after_shop_loop_item' );
    ?>
    <?php /* Direct button example from README - use WooCommerce hook instead ideally */ ?>
    <?php /* <button class="add-to-cart-btn"><?php esc_html_e('Add to Cart', 'cuevas'); ?></button> */ ?>
  </div>
</div> 