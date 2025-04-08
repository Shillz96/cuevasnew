<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cuevas_Western_Wear
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area sidebar">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
	
	<div class="sidebar-widget western-categories">
		<h3 class="widget-title">Shop Categories</h3>
		<ul>
			<li><a href="#">Men's Boots</a></li>
			<li><a href="#">Women's Boots</a></li>
			<li><a href="#">Western Hats</a></li>
			<li><a href="#">Belts & Buckles</a></li>
			<li><a href="#">Western Shirts</a></li>
			<li><a href="#">Accessories</a></li>
		</ul>
	</div>
	
	<div class="sidebar-widget featured-products">
		<h3 class="widget-title">Featured Products</h3>
		<?php
		// Display featured products
		if ( function_exists( 'wc_get_featured_product_ids' ) ) {
			$featured_product_ids = wc_get_featured_product_ids();
			
			if ( $featured_product_ids ) {
				// Just display the first 3 featured products
				$featured_product_ids = array_slice( $featured_product_ids, 0, 3 );
				
				foreach ( $featured_product_ids as $product_id ) {
					$product = wc_get_product( $product_id );
					?>
					<div class="mini-product">
						<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>">
							<?php echo $product->get_image( 'thumbnail' ); ?>
							<h4><?php echo $product->get_name(); ?></h4>
							<span class="price"><?php echo $product->get_price_html(); ?></span>
						</a>
					</div>
					<?php
				}
			}
		}
		?>
	</div>
</aside><!-- #secondary --> 