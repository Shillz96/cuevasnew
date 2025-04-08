<?php
/**
 * Template part for displaying the contact page content
 *
 * @package Cuevas_Western_Wear
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('contact-page'); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<div class="contact-container">
			<div class="contact-info">
				<div class="contact-section">
					<h3><i class="fas fa-map-marker-alt"></i> Visit Us</h3>
					<p>123 Western Avenue<br>Austin, TX 78701</p>
					
					<h4>Store Hours</h4>
					<ul class="hours-list">
						<li><span>Monday - Friday:</span> 9:00 AM - 8:00 PM</li>
						<li><span>Saturday:</span> 10:00 AM - 6:00 PM</li>
						<li><span>Sunday:</span> 12:00 PM - 5:00 PM</li>
					</ul>
				</div>
				
				<div class="contact-section">
					<h3><i class="fas fa-phone"></i> Call Us</h3>
					<p>(555) 123-4567</p>
					
					<h3><i class="fas fa-envelope"></i> Email Us</h3>
					<p><a href="mailto:info@cuevaswesternwear.com">info@cuevaswesternwear.com</a></p>
				</div>
				
				<div class="contact-section">
					<h3><i class="fas fa-heart"></i> Follow Us</h3>
					<div class="social-links">
						<a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
						<a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
						<a href="#" target="_blank"><i class="fab fa-pinterest-p"></i></a>
						<a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
					</div>
				</div>
			</div>
			
			<div class="contact-form">
				<h3>Send Us a Message</h3>
				<?php 
				// Check if Contact Form 7 is active
				if (function_exists('wpcf7_contact_form')) {
					// Display contact form with ID 123 (replace with actual CF7 form ID)
					echo do_shortcode('[contact-form-7 id="123" title="Contact Form"]');
				} else {
					// Fallback message if CF7 is not active
					echo '<p>Contact form plugin is not active. Please install and activate Contact Form 7.</p>';
				}
				?>
			</div>
		</div>
		
		<div class="store-map">
			<h3>Find Us</h3>
			<!-- Replace with your Google Maps embed code -->
			<div class="map-container">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d110545.70478049528!2d-97.78409803611325!3d30.260834396961538!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8644b599a0cc032f%3A0x5d9b464bd469d57a!2sAustin%2C%20TX!5e0!3m2!1sen!2sus!4v1678904835350!5m2!1sen!2sus" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</div>
		</div>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> --> 