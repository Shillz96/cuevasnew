<?php
/**
 * The front page template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cuevas_Western_Wear
 */

// Output debugging information if function exists
if (function_exists('cuevas_debug_log')) {
    cuevas_debug_log('Loading front-page.php template');
}

get_header();
?>

<main id="primary" class="site-main">
    <?php
    // Debug section loading
    if (function_exists('cuevas_debug_log')) {
        cuevas_debug_log('Starting to load homepage sections');
    }
    
    // 1. Hero Section
    if (function_exists('cuevas_debug_log')) {
        cuevas_debug_log('Loading hero section');
    }
    get_template_part('template-parts/homepage/hero-section');
    
    // 2. Gallery Section (Split Slideshow)
    if (function_exists('cuevas_debug_log')) {
        cuevas_debug_log('Loading split slideshow section');
    }
    get_template_part('template-parts/homepage/split-slideshow');
    
    // 3. Full-screen Product Grid
    if (function_exists('cuevas_debug_log')) {
        cuevas_debug_log('Loading full-screen product grid');
    }
    get_template_part('template-parts/homepage/products-grid');
    
    // 4. Shop Categories Section
    if (function_exists('cuevas_debug_log')) {
        cuevas_debug_log('Loading shop categories section');
    }
    get_template_part('template-parts/homepage/shop-categories');
    
    // Additional page content from WordPress editor (if needed)
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            
            // Only display content if there is any
            $content = get_the_content();
            if (!empty($content)) :
                if (function_exists('cuevas_debug_log')) {
                    cuevas_debug_log('Loading additional content section');
                }
            ?>
            <section class="homepage-section additional-content-section">
                <div class="container">
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>
            <?php
            endif;
        endwhile;
    endif;
    ?>
</main><!-- #primary -->

<?php
get_footer();
?>