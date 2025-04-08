<?php
/**
 * Empty cart page
 *
 * This template has been customized for Cuevas Western Wear with an Aether-inspired design.
 * Clean layout with clear typography and a prominent call-to-action.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<div class="empty-cart-container">
		<div class="empty-cart-icon">
			<i class="fas fa-shopping-bag"></i>
		</div>
		<p class="return-to-shop">
			<a class="button wc-backward<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
				<?php
					/**
					 * Filter "Return To Shop" text.
					 *
					 * @since 4.6.0
					 * @param string $default_text Default text.
					 */
					echo esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Return to shop', 'woocommerce' ) ) );
				?>
			</a>
		</p>
		
		<?php if ( function_exists( 'wc_get_featured_product_ids' ) ) : ?>
			<div class="empty-cart-suggestions">
				<h3><?php esc_html_e( 'You might like', 'woocommerce' ); ?></h3>
				<div class="featured-products">
					<?php
					$featured_products = wc_get_featured_product_ids();
					if ( ! empty( $featured_products ) ) {
						$featured_products = array_slice( $featured_products, 0, 3 );
						foreach ( $featured_products as $product_id ) {
							$product = wc_get_product( $product_id );
							if ( $product ) {
								echo '<div class="featured-product">';
								echo '<a href="' . esc_url( get_permalink( $product_id ) ) . '">';
								echo wp_kses_post( $product->get_image() );
								echo '<h4>' . esc_html( $product->get_name() ) . '</h4>';
								echo '<span class="price">' . wp_kses_post( $product->get_price_html() ) . '</span>';
								echo '</a>';
								echo '</div>';
							}
						}
					}
					?>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?> 