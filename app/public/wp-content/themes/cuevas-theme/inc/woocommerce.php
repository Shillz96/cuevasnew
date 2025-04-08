<?php
/**
 * WooCommerce specific functions and customizations
 *
 * @package Cuevas_Western_Wear
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add WooCommerce specific classes to the body tag
 */
function cuevas_woocommerce_body_classes( $classes ) {
	if ( is_woocommerce() ) {
		$classes[] = 'woocommerce-active';
	}
	
	return $classes;
}
add_filter( 'body_class', 'cuevas_woocommerce_body_classes' );

/**
 * Related Products Args.
 */
function cuevas_woocommerce_related_products_args( $args ) {
	// Ensure $args is an array before processing
	if ( ! is_array( $args ) ) {
		$args = array(); // Initialize as empty array if not valid
	}

	$defaults = array(
		'posts_per_page' => 8, // Show 8 products (for a 2x4 grid)
		'columns'        => 4, // Display in 4 columns
	);

	// Merge defaults with incoming args
	$args = wp_parse_args( $args, $defaults );

	return $args;
}
// Re-enable the filter now that the function is safer
add_filter( 'woocommerce_output_related_products_args', 'cuevas_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Add custom WooCommerce wrapper with western styling.
 */
if ( ! function_exists( 'cuevas_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 */
	function cuevas_woocommerce_wrapper_before() {
		?>
		<main id="primary" class="site-main woocommerce-content">
			<div class="woocommerce-wrapper">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'cuevas_woocommerce_wrapper_before' );

if ( ! function_exists( 'cuevas_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 */
	function cuevas_woocommerce_wrapper_after() {
		?>
			</div><!-- .woocommerce-wrapper -->
		</main><!-- #primary -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'cuevas_woocommerce_wrapper_after' );

/**
 * Customize the product display on shop pages.
 */
// function cuevas_woocommerce_loop_product_title() { ... } - Check if needed
// remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
// add_action( 'woocommerce_shop_loop_item_title', 'cuevas_woocommerce_loop_product_title', 10 );

/**
 * Customize the add to cart button text.
 */
// function cuevas_woocommerce_product_add_to_cart_text( $text ) { ... } - Check if needed
// add_filter( 'woocommerce_product_add_to_cart_text', 'cuevas_woocommerce_product_add_to_cart_text' );

/**
 * Ensure cart contents update when products are added to the cart via AJAX.
 */
function cuevas_woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
	<span class="cart-contents-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
	<?php
	$fragments['span.cart-contents-count'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'cuevas_woocommerce_header_add_to_cart_fragment' );

/**
 * Customize the number of products displayed per page.
 */
function cuevas_woocommerce_products_per_page() {
	return 12; // Display 12 products per page
}
add_filter( 'loop_shop_per_page', 'cuevas_woocommerce_products_per_page' );

/**
 * Customize WooCommerce checkout fields.
 */
// function cuevas_woocommerce_checkout_fields( $fields ) { ... } - Check if needed
// add_filter( 'woocommerce_checkout_fields', 'cuevas_woocommerce_checkout_fields' );

/**
 * Add custom order data to the order.
 */
// function cuevas_woocommerce_checkout_update_order_meta( $order_id ) { ... } - Check if needed
// add_action( 'woocommerce_checkout_update_order_meta', 'cuevas_woocommerce_checkout_update_order_meta' );

/**
 * Filter product classes to remove default WooCommerce classes if needed
 * and potentially add our own 'product-card'.
 * Note: We will wrap with product-card div instead, so removing default might not be needed.
 */
// function cuevas_filter_product_classes($classes, $class, $product_id) {
// 	// Example: Remove a default class
// 	// $classes = array_diff($classes, array('type-product'));
// 	// Example: Add our class
// 	$classes[] = 'product-card'; 
// 	return $classes;
// }
// add_filter('post_class', 'cuevas_filter_product_classes', 20, 3);

// --- Restructure Shop Loop Items conditionally ---

// Check if any hooks here might be mistakenly affecting single product gallery
// For example, a hook modifying `post_class` globally or filtering image HTML might exist.

// Example (If Present): Review any filters on 'woocommerce_single_product_image_thumbnail_html'
// Example (If Present): Review any filters on 'woocommerce_product_get_gallery_image_ids'

// Let's comment out the conditional shop loop restructuring temporarily 
// to see if it has any unintended side effects on the single product page gallery.
if ( function_exists('is_woocommerce') && is_woocommerce() && ( is_shop() || is_product_category() || is_product_tag() ) && is_main_query() ) {
	// 1. Remove default actions
	remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
	remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
	remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
	remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

	// 2. Add opening wrappers and link
	function cuevas_product_card_open() {
		global $product;
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
		echo '<div class="product-card">'; // Open product-card
		echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">'; // Re-add link opening
		echo '<div class="product-image-container">'; // Open image container
		
		if ($product->is_on_sale()) {
			echo '<span class="onsale product-badge badge-sale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>';
		}
		$post_date = get_the_time('U', $product->get_id());
		$time_diff = time() - $post_date;
		if ($time_diff < (30 * DAY_IN_SECONDS)) { 
			echo '<span class="new-badge product-badge badge-new">' . esc_html__( 'New', 'cuevas' ) . '</span>';
		}
	}
	add_action('woocommerce_before_shop_loop_item', 'cuevas_product_card_open', 5);

	// 3. Add product image
	function cuevas_product_card_image() {
		// This function might need to be defined or use woocommerce_template_loop_product_thumbnail
		woocommerce_template_loop_product_thumbnail();
	} 
    add_action('woocommerce_before_shop_loop_item_title', 'cuevas_product_card_image', 11); 

	// 4. Close image container, open info container, add title
	function cuevas_product_card_info_open() {
		echo '</div>'; // Close product-image-container
		echo '<div class="product-info">'; // Open product-info
		echo '<h2 class="product-title">' . get_the_title() . '</h2>'; 
	}
	add_action('woocommerce_before_shop_loop_item_title', 'cuevas_product_card_info_open', 20); 

	// 5. Add Price and Add to Cart Button
	function cuevas_product_card_price_button() {
		global $product;
		if ( $price_html = $product->get_price_html() ) {
			echo '<span class="product-price">' . $price_html . '</span>';
		}
		woocommerce_template_loop_add_to_cart( array('class' => 'button add-to-cart-btn') );
	}
	add_action('woocommerce_after_shop_loop_item_title', 'cuevas_product_card_price_button', 10);

	// 6. Close wrappers and link
	function cuevas_product_card_close() {
		echo '</div>'; // Close product-info
		echo '</a>'; // Close product link
		echo '</div>'; // Close product-card
	}
	add_action('woocommerce_after_shop_loop_item', 'cuevas_product_card_close', 15);
}

// --- End Restructure --- 