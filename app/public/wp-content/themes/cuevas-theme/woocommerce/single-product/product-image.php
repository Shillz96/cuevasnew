<?php
/**
 * Single Product Image
 *
 * This template has been customized for Cuevas Western Wear with an Aether-inspired design.
 * Vertical thumbnails layout with generous image size and elegant hover effects.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined('ABSPATH') || exit;

global $product;

$columns           = apply_filters('woocommerce_product_thumbnails_columns', 1); // Set to 1 for vertical layout
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
    'woocommerce_single_product_image_gallery_classes',
    array(
        'woocommerce-product-gallery',
        'woocommerce-product-gallery--' . ($post_thumbnail_id ? 'with-images' : 'without-images'),
        'woocommerce-product-gallery--columns-' . absint($columns),
        'images',
        'vertical-gallery',  // Keep our custom class
    )
);

// Get gallery image IDs
$gallery_image_ids = $product->get_gallery_image_ids();
?>
<div class="<?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?>" 
     data-columns="<?php echo esc_attr($columns); ?>" 
     style="opacity: 0; transition: opacity .25s ease-in-out;">
    <figure class="woocommerce-product-gallery__wrapper">
        <div class="gallery-layout-vertical">
            <?php if (!empty($gallery_image_ids)) : ?>
                <div class="thumbnail-slider">
                    <?php
                    // Show main image in thumbnails
                    if ($post_thumbnail_id) {
                        echo '<div class="thumbnail-item active" data-slide="0">';
                        echo wp_get_attachment_image($post_thumbnail_id, 'thumbnail', false, array(
                            'class' => 'thumbnail-image',
                            'alt'   => trim(wp_strip_all_tags(get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true)))
                        ));
                        echo '</div>';
                    }
                    
                    // Show gallery images in thumbnails
                    $slide_index = 1;
                    foreach ($gallery_image_ids as $gallery_image_id) {
                        echo '<div class="thumbnail-item" data-slide="' . esc_attr($slide_index) . '">';
                        echo wp_get_attachment_image($gallery_image_id, 'thumbnail', false, array(
                            'class' => 'thumbnail-image',
                            'alt'   => trim(wp_strip_all_tags(get_post_meta($gallery_image_id, '_wp_attachment_image_alt', true)))
                        ));
                        echo '</div>';
                        $slide_index++;
                    }
                    ?>
                </div>
            <?php endif; ?>
            
            <div class="main-image-slider">
                <?php
                if ($post_thumbnail_id) {
                    $html = wc_get_gallery_image_html($post_thumbnail_id, true);
                } else {
                    $html = '<div class="woocommerce-product-gallery__image--placeholder">';
                    $html .= sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_html__('Awaiting product image', 'woocommerce'));
                    $html .= '</div>';
                }

                echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id);

                // Gallery images
                if (!empty($gallery_image_ids)) {
                    foreach ($gallery_image_ids as $gallery_image_id) {
                        $html = wc_get_gallery_image_html($gallery_image_id, false);
                        echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $gallery_image_id);
                    }
                }
                ?>
            </div>
        </div>
    </figure>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the thumbnail click handling
        const thumbs = document.querySelectorAll('.thumbnail-item');
        const mainImages = document.querySelectorAll('.woocommerce-product-gallery__image');

        if (thumbs.length && mainImages.length) {
            // Hide all main images except first
            mainImages.forEach((img, index) => {
                if (index > 0) img.style.display = 'none';
                img.setAttribute('data-index', index);
            });

            // Set up click handlers for thumbnails
            thumbs.forEach(thumb => {
                thumb.addEventListener('click', function() {
                    // Update active class
                    thumbs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show corresponding main image
                    const slideIndex = parseInt(this.getAttribute('data-slide'));
                    mainImages.forEach((img, index) => {
                        img.style.display = (index === slideIndex) ? 'block' : 'none';
                    });
                });
            });
            
            // Initialize GSAP animations if available
            if (typeof gsap !== 'undefined') {
                // Fade in gallery
                gsap.to('.woocommerce-product-gallery', { 
                    opacity: 1, 
                    duration: 0.5, 
                    ease: 'power2.out' 
                });

                // Add hover effect to thumbnails
                thumbs.forEach(thumb => {
                    thumb.addEventListener('mouseenter', function() {
                        gsap.to(this, { scale: 1.05, duration: 0.2 });
                    });
                    
                    thumb.addEventListener('mouseleave', function() {
                        gsap.to(this, { scale: 1, duration: 0.2 });
                    });
                });
            } else {
                // Simple fallback if GSAP is not available
                document.querySelector('.woocommerce-product-gallery').style.opacity = 1;
            }
        }
    });
</script> 