<?php
/**
 * Template part for displaying the split slideshow on the homepage
 *
 * @package Cuevas_Western_Wear
 */

// Get slideshow images from Customizer
$slides = array();

// Slide 1
$image1 = get_theme_mod('cuevas_gallery_image_1', 'https://placehold.co/1920x1080/8B4513/FFF?text=Authentic');
$text1 = get_theme_mod('cuevas_gallery_text_1', 'Authentic');
if (!empty($image1)) {
    $slides[] = array(
        'image' => $image1,
        'text' => $text1
    );
}

// Slide 2
$image2 = get_theme_mod('cuevas_gallery_image_2', 'https://placehold.co/1920x1080/A52A2A/FFF?text=Western');
$text2 = get_theme_mod('cuevas_gallery_text_2', 'Western');
if (!empty($image2)) {
    $slides[] = array(
        'image' => $image2,
        'text' => $text2
    );
}

// Slide 3
$image3 = get_theme_mod('cuevas_gallery_image_3', 'https://placehold.co/1920x1080/D2691E/FFF?text=Heritage');
$text3 = get_theme_mod('cuevas_gallery_text_3', 'Heritage');
if (!empty($image3)) {
    $slides[] = array(
        'image' => $image3,
        'text' => $text3
    );
}

// Slide 4
$image4 = get_theme_mod('cuevas_gallery_image_4', 'https://placehold.co/1920x1080/CD853F/FFF?text=Tradition');
$text4 = get_theme_mod('cuevas_gallery_text_4', 'Tradition');
if (!empty($image4)) {
    $slides[] = array(
        'image' => $image4,
        'text' => $text4
    );
}

// Fallback if no slides are set in customizer
if (empty($slides)) {
    // Default fallback slides using placeholder service
    $slides = array(
        array(
            'image' => 'https://placehold.co/1920x1080/8B4513/FFF?text=Authentic',
            'text' => 'Authentic'
        ),
        array(
            'image' => 'https://placehold.co/1920x1080/A52A2A/FFF?text=Western',
            'text' => 'Western'
        ),
        array(
            'image' => 'https://placehold.co/1920x1080/D2691E/FFF?text=Heritage',
            'text' => 'Heritage'
        ),
        array(
            'image' => 'https://placehold.co/1920x1080/CD853F/FFF?text=Tradition',
            'text' => 'Tradition'
        ),
    );
}

// Only show if we have slides
if (!empty($slides)) :
?>
<section id="gallery-section" class="homepage-section split-slideshow" data-section-name="gallery">
    <div class="slideshow">
        <div class="slider">
            <?php foreach ($slides as $slide) : ?>
                <div class="item">
                    <?php if (isset($slide['image']) && !empty($slide['image'])) : 
                        // Handle both ACF image array and direct URL
                        $image_url = is_array($slide['image']) ? $slide['image']['url'] : $slide['image'];
                    ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($slide['text']); ?>" />
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Text section restored -->
    
    <div class="slideshow-text">
        <?php foreach ($slides as $slide) : ?>
            <div class="item"><?php echo esc_html($slide['text']); ?></div>
        <?php endforeach; ?>
    </div>
    
</section><!-- #gallery-section -->
<?php endif; ?> 