<?php
/**
 * Template part for displaying the hero section on the homepage
 *
 * @package Cuevas_Western_Wear
 */

// Get hero image from theme customizer or use default
$default_hero = 'https://placehold.co/1920x1080/8B4513/FFF?text=Cuevas+Western+Wear';
$hero_image = get_theme_mod('cuevas_hero_image', $default_hero);
$hero_title = get_theme_mod('cuevas_hero_title', 'Cuevas Western Wear');
$hero_subtitle = get_theme_mod('cuevas_hero_subtitle', 'Authentic Western Style');
$hero_button_text = get_theme_mod('cuevas_hero_button_text', 'Shop Now');
$hero_button_url = get_theme_mod('cuevas_hero_button_url', '#shop-categories');
?>

<section id="hero-section" class="homepage-section hero-section" data-section-name="home" style="<?php echo $hero_image ? 'background-image: url(' . esc_url($hero_image) . ');' : ''; ?>">
    <div class="hero-image" style="background-image: url('<?php echo esc_url($hero_image); ?>');">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title"><?php echo esc_html($hero_title); ?></h1>
            <p class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
            
            <div class="hero-button-container">
                <a href="/our-story/" class="hero-button">
                    <?php esc_html_e('Our Story', 'cuevas'); ?>
                </a>
                
                <?php if ($hero_button_text && $hero_button_url) : ?>
                    <a href="<?php echo esc_url($hero_button_url); ?>" class="hero-button">
                        <?php echo esc_html($hero_button_text); ?>
                    </a>
                <?php endif; ?>
                
                <a href="/contact/" class="hero-button">
                     <?php esc_html_e('Contact Us', 'cuevas'); ?>
                </a>
            </div>

        </div>
    </div>
</section><!-- #hero-section --> 