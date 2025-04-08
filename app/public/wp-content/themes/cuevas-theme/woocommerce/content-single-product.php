<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'cuevas-single-product', $product ); ?>>
	
	<div class="product-layout">
		<div class="product-gallery-column">
			<?php
			/**
			 * Hook: woocommerce_before_single_product_summary.
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
			?>
		</div>

		<div class="product-details-column">
			<div class="summary entry-summary">
				<div class="product-brand">
					<?php 
					// Display product brand if available
					$brand_terms = get_the_terms($product->get_id(), 'product_brand');
					if ($brand_terms && !is_wp_error($brand_terms)) {
						$brand = array_shift($brand_terms);
						echo '<span class="brand-name">' . esc_html($brand->name) . '</span>';
					}
					?>
				</div>
				
				<?php
				/**
				 * Hook: woocommerce_single_product_summary.
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked WC_Structured_Data::generate_product_data() - 60
				 */
				do_action( 'woocommerce_single_product_summary' );
				?>
				
				<div class="product-features">
					<h3><?php esc_html_e('Features', 'cuevas'); ?></h3>
					<ul class="features-list">
						<?php
						// Get custom product features
						$features = get_post_meta($product->get_id(), '_product_features', true);
						if (!empty($features)) {
							$features_array = explode("\n", $features);
							foreach ($features_array as $feature) {
								echo '<li><i class="fas fa-check"></i> ' . esc_html(trim($feature)) . '</li>';
							}
						} else {
							// Display some default features from the description
							$short_description = $product->get_short_description();
							if (!empty($short_description)) {
								echo '<li><i class="fas fa-check"></i> Premium Quality</li>';
								echo '<li><i class="fas fa-check"></i> Western Style</li>';
								echo '<li><i class="fas fa-check"></i> Handcrafted with Care</li>';
							}
						}
						?>
					</ul>
				</div>
				
				<div class="shipping-info">
					<p><i class="fas fa-truck"></i> <?php esc_html_e('Free shipping on orders over $100', 'cuevas'); ?></p>
					<p><i class="fas fa-undo"></i> <?php esc_html_e('30-day return policy', 'cuevas'); ?></p>
				</div>
			</div>
		</div>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?> 