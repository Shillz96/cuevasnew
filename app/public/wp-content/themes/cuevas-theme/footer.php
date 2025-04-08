<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cuevas_Western_Wear
 */

?>

	</div><!-- #content -->

	<?php 
	// Conditionally display the footer: NOT on the front page.
	if ( ! is_front_page() ) : 
	?>
	<footer id="colophon" class="site-footer">
		<div class="container">
			
			<?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>
				<div class="footer-widgets">
					<?php dynamic_sidebar( 'footer-sidebar' ); ?>
				</div><!-- .footer-widgets -->
			<?php endif; ?>

			<?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
				<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'cuevas' ); ?>">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer-menu',
						'menu_class'     => 'footer-menu',
						'depth'          => 1,
					) );
					?>
				</nav><!-- .footer-navigation -->
			<?php endif; ?>

			<div class="site-info">
				<span class="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'cuevas' ); ?></span>
				<?php 
				// Optional: Add links to privacy policy/terms if needed
				// Example: echo ' | <a href="#">Privacy Policy</a>'; 
				?>
			</div><!-- .site-info -->
		</div><!-- .container -->
	</footer><!-- #colophon -->
	<?php endif; // End !is_front_page() check ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html> 