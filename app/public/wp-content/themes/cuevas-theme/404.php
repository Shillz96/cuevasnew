<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Cuevas_Western_Wear
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="container">
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'cuevas' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try searching for what you are looking for?', 'cuevas' ); ?></p>

					<div class="error-image">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/404-cowboy-hat.svg' ); ?>" alt="404 Cowboy Hat">
					</div>

					<?php get_search_form(); ?>

					<div class="error-navigation">
						<div class="error-links">
							<h3><?php esc_html_e( 'Popular Categories', 'cuevas' ); ?></h3>
							<ul>
								<?php
								wp_list_categories(
									array(
										'orderby'    => 'count',
										'order'      => 'DESC',
										'show_count' => 1,
										'title_li'   => '',
										'number'     => 5,
									)
								);
								?>
							</ul>
						</div>

						<div class="error-links">
							<h3><?php esc_html_e( 'Featured Products', 'cuevas' ); ?></h3>
							<ul>
								<?php
								if ( function_exists( 'wc_get_featured_product_ids' ) ) {
									$featured_product_ids = wc_get_featured_product_ids();
									
									if ( ! empty( $featured_product_ids ) ) {
										foreach ( array_slice( $featured_product_ids, 0, 5 ) as $product_id ) {
											echo '<li><a href="' . esc_url( get_permalink( $product_id ) ) . '">' . get_the_title( $product_id ) . '</a></li>';
										}
									}
								}
								?>
							</ul>
						</div>
					</div>

					<div class="back-home">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button"><?php esc_html_e( 'Back to Home', 'cuevas' ); ?></a>
					</div>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</div>
	</main><!-- #main -->

<?php
get_footer(); 