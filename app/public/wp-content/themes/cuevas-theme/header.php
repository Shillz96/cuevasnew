<?php
/**
 * The header for our theme
 *
 * @package CuevasWesternWear
 */

// Get navigation customizer settings
$nav_bg_color = get_theme_mod('cuevas_nav_bg_color', '#3E2723');
$nav_text_color = get_theme_mod('cuevas_nav_text_color', '#FFFFFF');
// $nav_transparent = get_theme_mod('cuevas_nav_transparent', true); // No longer needed for class logic

// Base header class
$header_class = 'site-header'; 

// Check if we need the compact header class for shop pages
if (function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag())) {
    $header_class .= ' compact-header'; // Append compact class if on shop pages
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'cuevas'); ?></a>

    <?php 
    // REMOVED Conditional check - Header HTML will always be output
    ?>
    <header id="masthead" class="<?php echo esc_attr($header_class); ?>">
        <div class="container">
            <div class="header-inner">
                
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'cuevas' ); ?></span>
                </button>

                <div class="site-branding">
                    <?php
                    // Display the custom logo if available
                    if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
                        the_custom_logo();
                    } else {
                        // Fallback to site title if no logo is set
                        if ( is_front_page() && is_home() ) :
                            ?>
                            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                            <?php
                        else :
                            ?>
                            <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                            <?php
                        endif;
                        $cuevas_description = get_bloginfo( 'description', 'display' );
                        if ( $cuevas_description || is_customize_preview() ) :
                            ?>
                            <p class="site-description"><?php echo $cuevas_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                        <?php endif;
                    }
                    ?>
                </div><!-- .site-branding -->

                <nav id="site-navigation" class="main-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary-menu',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                    ));
                    ?>
                    <?php if (function_exists('wc_get_cart_url')) : ?>
                    <div class="nav-extras">
                        <ul>
                            <li><a href="#" class="search-icon" aria-label="<?php esc_attr_e('Search', 'cuevas'); ?>"><i class="fas fa-search"></i></a></li>
                            <li><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="account-icon" aria-label="<?php esc_attr_e('My Account', 'cuevas'); ?>"><i class="fas fa-user"></i></a></li>
                            <li>
                                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-icon" aria-label="<?php esc_attr_e('Cart', 'cuevas'); ?>">
                                    <i class="fas fa-shopping-bag"></i>
                                    <span class="cart-contents-count"><?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : '0'; ?></span>
                                </a>
                            </li>
                        </ul>
                    </div><!-- .nav-extras -->
                    <?php endif; ?>
                </nav><!-- #site-navigation -->
            </div>
        </div>
    </header>
    <?php 
    // REMOVED endif
    ?>

    <?php
    // Display shop banner if on shop page
    if (function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag())) :
        $category_image = '';
        $category_title = '';
        
        if (is_product_category()) {
            $category = get_queried_object();
            $category_title = $category->name;
            $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
            if ($thumbnail_id) {
                $category_image = wp_get_attachment_url($thumbnail_id);
            }
        } elseif (is_shop()) {
            $category_title = esc_html__('Shop', 'cuevas');
            if (function_exists('wc_get_page_id')) {
                $shop_page_id = wc_get_page_id('shop');
                if (has_post_thumbnail($shop_page_id)) {
                    $category_image = get_the_post_thumbnail_url($shop_page_id, 'full');
                }
            }
        }
    ?>
    <!-- Category Banner -->
    <section class="category-banner">
        <?php if ($category_image) : ?>
            <img src="<?php echo esc_url($category_image); ?>" alt="<?php echo esc_attr($category_title); ?>" class="banner-bg">
        <?php endif; ?>
        <div class="banner-content">
            <h1 class="category-title"><?php echo esc_html($category_title); ?></h1>
            <?php
            if (function_exists('woocommerce_breadcrumb')) {
                woocommerce_breadcrumb(array(
                    'wrap_before' => '<div class="breadcrumbs">',
                    'wrap_after'  => '</div>',
                    'before'      => '<div class="breadcrumb-item">',
                    'after'       => '</div>',
                    'delimiter'   => '',
                ));
            }
            ?>
        </div>
    </section>
    <?php endif; ?>

    <div id="content" class="site-content full-width-content">
        <?php // Adjust container logic slightly as header padding is now conditional 
        $needs_container = !is_front_page(); // Assume non-front pages need container
        if (function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag())) {
             $needs_container = true; // Shop pages definitely need container
        }
        
        if ($needs_container): ?>
            <div class="<?php echo (function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag())) ? 'shop-container container' : 'container'; ?>">
        <?php endif; ?> 