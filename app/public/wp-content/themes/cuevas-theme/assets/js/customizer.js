/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 */

( function( $ ) {
	// Update the site title in real time
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	
	// Update the site description in real time
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	
	// Update hero section in real time
	wp.customize( 'cuevas_hero_title', function( value ) {
		value.bind( function( to ) {
			$( '.hero-title' ).text( to );
		} );
	} );
	
	wp.customize( 'cuevas_hero_subtitle', function( value ) {
		value.bind( function( to ) {
			$( '.hero-subtitle' ).text( to );
		} );
	} );
	
	wp.customize( 'cuevas_hero_button_text', function( value ) {
		value.bind( function( to ) {
			$( '.hero-button' ).text( to );
		} );
	} );
	
	wp.customize( 'cuevas_hero_button_url', function( value ) {
		value.bind( function( to ) {
			$( '.hero-button' ).attr( 'href', to );
		} );
	} );
	
	// Update featured products section in real time
	wp.customize( 'cuevas_featured_products_title', function( value ) {
		value.bind( function( to ) {
			$( '#featured-products .section-title' ).text( to );
		} );
	} );
	
	wp.customize( 'cuevas_featured_products_subtitle', function( value ) {
		value.bind( function( to ) {
			$( '#featured-products .section-subtitle' ).text( to );
		} );
	} );
	
	// Update shop categories section in real time
	wp.customize( 'cuevas_shop_categories_title', function( value ) {
		value.bind( function( to ) {
			$( '#shop-categories .section-title' ).text( to );
		} );
	} );
	
	wp.customize( 'cuevas_shop_categories_subtitle', function( value ) {
		value.bind( function( to ) {
			$( '#shop-categories .section-subtitle' ).text( to );
		} );
	} );
	
	// Update shop categories section background image
	wp.customize('cuevas_shop_categories_bg_image', function(value) {
		value.bind(function(to) {
			if (to) {
				// Update the background image
				$('.shop-categories-background').css('background-image', 'url(' + to + ')');
				console.log('Updated shop categories background image to:', to);
			}
		});
	});
	
	// CTA Button Updates
	wp.customize( 'cuevas_shop_cta1_title', function( value ) {
		value.bind( function( to ) {
			$( '#shop-categories .cta-buttons a:nth-child(1)' ).text( to );
		} );
	} );
	
	wp.customize( 'cuevas_shop_cta1_url', function( value ) {
		value.bind( function( to ) {
			$( '#shop-categories .cta-buttons a:nth-child(1)' ).attr( 'href', to );
		} );
	} );
	
	wp.customize( 'cuevas_shop_cta2_title', function( value ) {
		value.bind( function( to ) {
			$( '#shop-categories .cta-buttons a:nth-child(2)' ).text( to );
		} );
	} );
	
	wp.customize( 'cuevas_shop_cta2_url', function( value ) {
		value.bind( function( to ) {
			$( '#shop-categories .cta-buttons a:nth-child(2)' ).attr( 'href', to );
		} );
	} );
	
	wp.customize( 'cuevas_shop_cta3_title', function( value ) {
		value.bind( function( to ) {
			$( '#shop-categories .cta-buttons a:nth-child(3)' ).text( to );
		} );
	} );
	
	wp.customize( 'cuevas_shop_cta3_url', function( value ) {
		value.bind( function( to ) {
			$( '#shop-categories .cta-buttons a:nth-child(3)' ).attr( 'href', to );
		} );
	} );
} )( jQuery ); 