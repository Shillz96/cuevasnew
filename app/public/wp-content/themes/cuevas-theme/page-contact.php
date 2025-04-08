<?php
/**
 * Template Name: Contact Page
 *
 * @package Cuevas_Western_Wear
 */

get_header();
?>

	<main id="primary" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'contact' );

		endwhile; // End of the loop.
		?>
	</main><!-- #main -->

<?php
get_footer(); 