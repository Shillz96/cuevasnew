<?php
/**
 * Template part for displaying the FAQ page content
 *
 * @package Cuevas_Western_Wear
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('faq-page'); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<div class="faq-intro">
			<p>Find answers to the most commonly asked questions about our products, services, and shopping experience.</p>
		</div>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<div class="faq-container">
			<div class="faq-sidebar">
				<div class="faq-filter">
					<h3>Categories</h3>
					<ul class="faq-categories">
						<li><a href="#general" class="active">General</a></li>
						<li><a href="#products">Products & Sizing</a></li>
						<li><a href="#orders">Orders & Payment</a></li>
						<li><a href="#shipping">Shipping & Delivery</a></li>
						<li><a href="#returns">Returns & Exchanges</a></li>
					</ul>
				</div>
				
				<div class="faq-search">
					<h3>Search</h3>
					<div class="faq-search-form">
						<input type="text" id="faq-search-input" placeholder="Search FAQs...">
						<button id="faq-search-btn"><i class="fas fa-search"></i></button>
					</div>
				</div>
				
				<div class="faq-contact">
					<h3>Need More Help?</h3>
					<p>Can't find what you're looking for? Our customer service team is here to help.</p>
					<a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-contact">Contact Us</a>
				</div>
			</div>
			
			<div class="faq-content">
				<section id="general" class="faq-section active">
					<h2>General Questions</h2>
					
					<div class="faq-item">
						<div class="faq-question">
							<h3>What makes Cuevas Western Wear different from other western clothing stores?</h3>
							<span class="faq-toggle"><i class="fas fa-plus"></i></span>
						</div>
						<div class="faq-answer">
							<p>Cuevas Western Wear stands out for our authentic craftsmanship and family heritage. For over four decades, our family-owned business has specialized in premium western apparel, with a focus on traditional techniques combined with modern styles. Unlike mass-produced items, many of our products are handcrafted by skilled artisans, ensuring uniqueness and exceptional quality.</p>
						</div>
					</div>
					
					<div class="faq-item">
						<div class="faq-question">
							<h3>Do you have physical store locations?</h3>
							<span class="faq-toggle"><i class="fas fa-plus"></i></span>
						</div>
						<div class="faq-answer">
							<p>Yes, we have our flagship store in Austin, Texas, where we started in 1978. You can visit us at 123 Western Avenue, Austin, TX 78701. Our store hours are Monday through Friday from 9:00 AM to 8:00 PM, Saturday from 10:00 AM to 6:00 PM, and Sunday from 12:00 PM to 5:00 PM.</p>
						</div>
					</div>
					
					<div class="faq-item">
						<div class="faq-question">
							<h3>Are your products ethically made?</h3>
							<span class="faq-toggle"><i class="fas fa-plus"></i></span>
						</div>
						<div class="faq-answer">
							<p>Absolutely. We're committed to ethical production methods and fair labor practices. Our in-house craftspeople work under excellent conditions, and we carefully select partners and suppliers who share our values. We're continually working to improve our sustainability practices and reduce our environmental impact while maintaining the highest quality standards.</p>
						</div>
					</div>
				</section>
				
				<section id="products" class="faq-section">
					<h2>Products & Sizing</h2>
					
					<div class="faq-item">
						<div class="faq-question">
							<h3>How do I find the right boot size?</h3>
							<span class="faq-toggle"><i class="fas fa-plus"></i></span>
						</div>
						<div class="faq-answer">
							<p>Finding the perfect boot fit is essential. We recommend measuring your foot length in inches while standing and referring to our <a href="<?php echo esc_url(home_url('/size-guide')); ?>">size guide</a>. Western boots typically require a break-in period of 5-10 wears. For the best fit, your boots should feel snug in the instep but allow enough room for your toes to move. If you're between sizes, we recommend sizing down for leather boots as they will stretch with wear.</p>
						</div>
					</div>
					
					<div class="faq-item">
						<div class="faq-question">
							<h3>How should I care for my leather products?</h3>
							<span class="faq-toggle"><i class="fas fa-plus"></i></span>
						</div>
						<div class="faq-answer">
							<p>To maintain your leather boots, hats, and accessories, we recommend regular cleaning with a soft brush to remove dust. For leather boots, apply a quality leather conditioner every 3-6 months to prevent drying and cracking. Keep leather products away from direct heat and sunlight, and allow wet leather to dry naturally at room temperature. For specific leather types like exotic skins, please check the care instructions included with your product or contact our customer service team.</p>
						</div>
					</div>
					
					<div class="faq-item">
						<div class="faq-question">
							<h3>Do you offer custom or personalized products?</h3>
							<span class="faq-toggle"><i class="fas fa-plus"></i></span>
						</div>
						<div class="faq-answer">
							<p>Yes, we offer custom boot making and hat shaping services. Our master craftspeople can create bespoke boots to your exact specifications, from leather type to stitching patterns. We also provide hat customization, including shaping, sizing, and adding personal touches. These services are available in-store or through our special order process online. Custom orders typically require 8-12 weeks for completion.</p>
						</div>
					</div>
				</section>
				
				<section id="orders" class="faq-section">
					<h2>Orders & Payment</h2>
					
					<div class="faq-item">
						<div class="faq-question">
							<h3>What payment methods do you accept?</h3>
							<span class="faq-toggle"><i class="fas fa-plus"></i></span>
						</div>
						<div class="faq-answer">
							<p>We accept all major credit cards (Visa, MasterCard, American Express, and Discover), PayPal, Apple Pay, and Google Pay. For special orders or custom work, we may require a deposit paid by credit card or bank transfer.</p>
						</div>
					</div>
					
					<div class="faq-item">
						<div class="faq-question">
							<h3>Can I modify or cancel my order?</h3>
							<span class="faq-toggle"><i class="fas fa-plus"></i></span>
						</div>
						<div class="faq-answer">
							<p>You can modify or cancel your order within 1 hour of placing it by contacting our customer service team. After this window, we begin processing orders, and changes may not be possible. Custom orders cannot be canceled once production has begun. Please review your order carefully before confirming your purchase.</p>
						</div>
					</div>
					
					<div class="faq-item">
						<div class="faq-question">
							<h3>Do you offer gift cards?</h3>
							<span class="faq-toggle"><i class="fas fa-plus"></i></span>
						</div>
						<div class="faq-answer">
							<p>Yes, we offer digital and physical gift cards in denominations from $25 to $500. Digital gift cards are delivered via email immediately after purchase. Physical gift cards are shipped to the address specified during checkout. Gift cards never expire and can be used for online or in-store purchases.</p>
						</div>
					</div>
				</section>
				
				<section id="shipping" class="faq-section">
					<h2>Shipping & Delivery</h2>
					
					<div class="faq-item">
						<div class="faq-question">
							<h3>What are your shipping options and costs?</h3>
							<span class="faq-toggle"><i class="fas fa-plus"></i></span>
						</div>
						<div class="faq-answer">
							<p>We offer several shipping options:</p>
							<ul>
								<li><strong>Standard Shipping (3-5 business days):</strong> $7.95 or free on orders over $100</li>
								<li><strong>Expedited Shipping (2-3 business days):</strong> $14.95</li>
								<li><strong>Next Day Shipping:</strong> $24.95</li>
							</ul>
							<p>International shipping is available to select countries with rates calculated at checkout based on destination and package weight. Custom and made-to-order items have separate shipping timeframes that will be communicated during the ordering process.</p>
						</div>
					</div>
					
					<div class="faq-item">
						<div class="faq-question">
							<h3>How can I track my order?</h3>
							<span class="faq-toggle"><i class="fas fa-plus"></i></span>
						</div>
						<div class="faq-answer">
							<p>Once your order ships, you'll receive a confirmation email with a tracking number and link. You can also track your order by logging into your account on our website and viewing your order history. Please allow 24 hours for tracking information to update after receiving your shipping confirmation.</p>
						</div>
					</div>
					
					<div class="faq-item">
						<div class="faq-question">
							<h3>Do you ship internationally?</h3>
							<span class="faq-toggle"><i class="fas fa-plus"></i></span>
						</div>
						<div class="faq-answer">
							<p>Yes, we ship to many countries worldwide. International customers are responsible for any customs fees, import taxes, or duties that may apply. These charges vary by country and are not included in our shipping fees. Delivery times for international orders typically range from 7-21 business days, depending on the destination and customs processing times.</p>
						</div>
					</div>
				</section>
				
				<section id="returns" class="faq-section">
					<h2>Returns & Exchanges</h2>
					
					<div class="faq-item">
						<div class="faq-question">
							<h3>What is your return policy?</h3>
							<span class="faq-toggle"><i class="fas fa-plus"></i></span>
						</div>
						<div class="faq-answer">
							<p>We offer a 30-day return policy for unworn, unwashed items in their original condition with all tags attached. Returns must be initiated within 30 days of delivery. Custom, personalized, and final sale items are not eligible for return. To start a return, please visit our <a href="<?php echo esc_url(home_url('/returns')); ?>">returns page</a> or contact our customer service team.</p>
						</div>
					</div>
					
					<div class="faq-item">
						<div class="faq-question">
							<h3>How do I exchange an item?</h3>
							<span class="faq-toggle"><i class="fas fa-plus"></i></span>
						</div>
						<div class="faq-answer">
							<p>For exchanges, please follow our return process and place a new order for the desired item. This ensures the item you want remains in stock and reaches you as quickly as possible. Once we receive your return, we'll process the refund to your original payment method. Exchanges follow the same eligibility requirements as our standard return policy.</p>
						</div>
					</div>
					
					<div class="faq-item">
						<div class="faq-question">
							<h3>Do you offer repairs or warranties?</h3>
							<span class="faq-toggle"><i class="fas fa-plus"></i></span>
						</div>
						<div class="faq-answer">
							<p>We stand behind the quality of our products. All Cuevas Western Wear branded items come with a 1-year warranty against manufacturing defects. For our boots, we offer repair services including sole replacement, heel repair, and stitching fixes for a reasonable fee, even after the warranty period. Please note that normal wear and tear is not covered under warranty, and improper care may void warranty coverage.</p>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> --> 