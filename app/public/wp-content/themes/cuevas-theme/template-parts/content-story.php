<?php
/**
 * Template part for displaying the Our Story page content
 *
 * @package Cuevas_Western_Wear
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('story-page'); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<div class="story-hero">
			<div class="story-hero-image">
				<?php 
				if (has_post_thumbnail()) {
					the_post_thumbnail('full', ['class' => 'hero-img']);
				} else {
					echo '<img src="' . get_template_directory_uri() . '/assets/images/story-hero.jpg" alt="Cuevas Western Wear Heritage" class="hero-img">';
				}
				?>
			</div>
			<div class="story-hero-overlay">
				<div class="story-hero-text">
					<h2>Authentic Western Heritage Since 1978</h2>
					<p>Family-owned for three generations, bringing quality craftsmanship to cowboys and cowgirls across the country.</p>
				</div>
			</div>
		</div>

		<div class="story-content-container">
			<div class="story-timeline">
				<div class="timeline-item">
					<div class="timeline-year">1978</div>
					<div class="timeline-content">
						<h3>The Beginning</h3>
						<p>Founder Miguel Cuevas opened the first small workshop in Austin, Texas, crafting custom leather boots for local ranchers.</p>
						<div class="timeline-image">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="The Beginning of Cuevas Western Wear">
						</div>
					</div>
				</div>
				
				<div class="timeline-item">
					<div class="timeline-year">1985</div>
					<div class="timeline-content">
						<h3>First Retail Store</h3>
						<p>After gaining recognition for exceptional craftsmanship, the first Cuevas Western Wear retail store opened its doors on South Congress Avenue.</p>
						<div class="timeline-image">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="First Cuevas Western Wear Store">
						</div>
					</div>
				</div>
				
				<div class="timeline-item">
					<div class="timeline-year">1997</div>
					<div class="timeline-content">
						<h3>Expanding the Collection</h3>
						<p>The second generation of the Cuevas family expanded beyond boots to include a full range of western apparel, hats, and accessories.</p>
						<div class="timeline-image">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="Cuevas Collection Expansion">
						</div>
					</div>
				</div>
				
				<div class="timeline-item">
					<div class="timeline-year">2012</div>
					<div class="timeline-content">
						<h3>National Recognition</h3>
						<p>Cuevas Western Wear became the official supplier for several professional rodeo champions, gaining national recognition for quality and authenticity.</p>
						<div class="timeline-image">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="Cuevas National Recognition">
						</div>
					</div>
				</div>
				
				<div class="timeline-item">
					<div class="timeline-year">2023</div>
					<div class="timeline-content">
						<h3>Today's Legacy</h3>
						<p>Now led by the third generation of the Cuevas family, we continue to blend traditional craftsmanship with modern western style, serving customers worldwide through our stores and online presence.</p>
						<div class="timeline-image">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="Cuevas Today">
						</div>
					</div>
				</div>
			</div>
			
			<div class="story-values">
				<h2>Our Values</h2>
				<div class="values-grid">
					<div class="value-item">
						<div class="value-icon">
							<i class="fas fa-hands"></i>
						</div>
						<h3>Craftsmanship</h3>
						<p>Every product reflects our commitment to quality materials and expert construction.</p>
					</div>
					
					<div class="value-item">
						<div class="value-icon">
							<i class="fas fa-hat-cowboy"></i>
						</div>
						<h3>Authenticity</h3>
						<p>True to western heritage and traditions while embracing contemporary style.</p>
					</div>
					
					<div class="value-item">
						<div class="value-icon">
							<i class="fas fa-users"></i>
						</div>
						<h3>Family</h3>
						<p>Built on family values, we treat our customers and partners as an extension of our family.</p>
					</div>
					
					<div class="value-item">
						<div class="value-icon">
							<i class="fas fa-leaf"></i>
						</div>
						<h3>Sustainability</h3>
						<p>Committed to ethical production and reducing our environmental footprint.</p>
					</div>
				</div>
			</div>
			
			<div class="story-team">
				<h2>Meet the Family</h2>
				<div class="team-grid">
					<div class="team-member">
						<div class="team-photo">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="Elena Cuevas">
						</div>
						<h3>Elena Cuevas</h3>
						<p class="team-title">CEO & Head Designer</p>
						<p class="team-bio">Granddaughter of founder Miguel Cuevas, Elena combines a deep respect for tradition with an eye for contemporary fashion.</p>
					</div>
					
					<div class="team-member">
						<div class="team-photo">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="Marco Cuevas">
						</div>
						<h3>Marco Cuevas</h3>
						<p class="team-title">Master Bootmaker</p>
						<p class="team-bio">With over 30 years of experience, Marco oversees our custom boot workshop, preserving the original Cuevas craftsmanship.</p>
					</div>
					
					<div class="team-member">
						<div class="team-photo">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="Sofia Cuevas">
						</div>
						<h3>Sofia Cuevas</h3>
						<p class="team-title">Operations Director</p>
						<p class="team-bio">Ensuring that our dedication to quality extends to every aspect of the customer experience, both in-store and online.</p>
					</div>
				</div>
			</div>
		</div>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> --> 