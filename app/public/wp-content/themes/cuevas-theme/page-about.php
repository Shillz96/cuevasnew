<?php
/**
 * Template Name: About Page
 * 
 * This is the template that displays the about page.
 * 
 * @package Cuevas_Theme
 */

get_header();
?>

<main class="site-main">
    <!-- Brand Story Component -->
    <section class="brand-section brand-pattern">
        <div class="container">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <h2 class="section-title text-center"><?php the_title(); ?></h2>
                <?php if (has_excerpt()) : ?>
                    <p class="section-subtitle text-center"><?php echo wp_kses_post(get_the_excerpt()); ?></p>
                <?php endif; ?>

                <div class="brand-story">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; endif; ?>
        </div>
    </section>

    <!-- Craftsmanship Section -->
    <section class="craftsmanship-section">
        <div class="container">
            <div class="craft-item">
                <img src="<?php echo esc_url(get_theme_file_uri('assets/img/placeholder.jpg')); ?>" 
                     alt="Craftsmanship" 
                     class="craftsmanship-image">
                <h4>Quality Craftsmanship</h4>
                <p>Experience the finest in western wear craftsmanship, where every stitch tells a story of dedication and excellence.</p>
            </div>
        </div>
    </section>

    <!-- Trust Badges Section -->
    <section class="section trust-section">
        <div class="container">
            <div class="trust-badges">
                <?php
                // Define a maximum number of badges to check for
                $max_badges = 6;

                for ( $i = 1; $i <= $max_badges; $i++ ) {
                    // Get custom field values for the current badge number
                    $icon_class = get_post_meta( get_the_ID(), 'trust_badge_' . $i . '_icon', true );
                    $title      = get_post_meta( get_the_ID(), 'trust_badge_' . $i . '_title', true );
                    $desc       = get_post_meta( get_the_ID(), 'trust_badge_' . $i . '_description', true );

                    // Only display the badge if all three fields have values
                    if ( ! empty( $icon_class ) && ! empty( $title ) && ! empty( $desc ) ) {
                        ?>
                        <div class="trust-badge">
                            <i class="<?php echo esc_attr( $icon_class ); ?> trust-icon"></i>
                            <h4 class="trust-title"><?php echo esc_html( $title ); ?></h4>
                            <p><?php echo esc_html( $desc ); ?></p>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
</main>

<?php
get_footer(); 