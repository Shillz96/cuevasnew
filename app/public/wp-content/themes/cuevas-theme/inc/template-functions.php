function cuevas_body_classes( $classes ) {
	// Adds a class for sites with a custom header image.
	if ( has_header_image() ) {
		$classes[] = 'has-header-image';
	}
	
	// Add a class for the home page with transparent header
	if ( is_front_page() ) {
		$classes[] = 'transparent-header-home';
	}
	
	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'cuevas_body_classes' ); 