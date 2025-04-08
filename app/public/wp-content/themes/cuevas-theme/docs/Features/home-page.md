# Home Page Template

## Overview
The home page is a visually engaging, full-width layout with four main sections: Hero, Gallery, Featured Products, and Shop Now. Each section occupies the full viewport height and width, snapping into view as the user scrolls. GSAP (GreenSock Animation Platform) powers seamless scroll-triggered animations.

## Template Hierarchy
This template follows the WordPress template hierarchy:
1. `front-page.php` (primary template for static front page)
2. `page-home.php` (fallback if the page slug is "home")
3. `page-{id}.php` (fallback using the page ID)
4. `page.php` (general template for all pages)
5. `singular.php` (used for all singular content)
6. `index.php` (ultimate fallback)

## Template File
**Primary File**: `front-page.php`

## Layout Components
1. **Hero Section**: A full-screen hero image set via the WordPress Customizer
2. **Gallery Section**: A series of full-screen images that animate as the user scrolls through them
3. **Featured Products Section**: Displays six featured WooCommerce products in a 2×3 grid
4. **Shop Now Section**: Three large call-to-action buttons linking to shop categories

## Core Functionality
- Full-screen sections with snap scrolling
- GSAP animations on scroll
- WooCommerce integration for featured products
- Customizer settings for hero and gallery images
- Responsive design for all device sizes

## Technical Requirements
1. **Structure**:
   - Custom template file: `front-page.php`
   - Full-width, full-height sections
   - No sidebar

2. **Animation**:
   - GSAP ScrollTrigger for snap scrolling
   - Staggered animations for products and buttons
   - Gallery image transitions

3. **WordPress Integration**:
   - Customizer settings for hero image
   - Customizer settings for gallery images
   - WP_Query for featured products

4. **Performance Considerations**:
   - Optimized image loading
   - Efficient GSAP animations
   - Responsive image handling

## Template Code Example
```php
<?php
/*
Template Name: Home Page
*/
get_header();
?>

<div class="container">
  <!-- Hero Section -->
  <section class="full-screen hero" style="background-image: url('<?php echo esc_url(get_theme_mod('hero_image', '')); ?>');">
    <!-- Optional: Add overlay text or buttons if desired -->
  </section>

  <!-- Gallery Section -->
  <?php
  $gallery_images = get_theme_mod('gallery_images', []);
  foreach ($gallery_images as $index => $image) {
    echo '<section class="full-screen gallery-item" style="background-image: url(\'' . esc_url($image) . '\');" data-gallery-index="' . $index . '"></section>';
  }
  ?>

  <!-- Featured Products Section -->
  <section class="full-screen featured-products">
    <div class="products-grid">
      <?php
      $args = array(
        'post_type' => 'product',
        'posts_per_page' => 6,
        'meta_query' => array(
          array(
            'key' => '_featured',
            'value' => 'yes',
          ),
        ),
      );
      $products = new WP_Query($args);
      if ($products->have_posts()) {
        while ($products->have_posts()) {
          $products->the_post();
          ?>
          <div class="product">
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail('medium'); ?>
              <h3><?php the_title(); ?></h3>
              <p><?php echo wc_price(get_post_meta(get_the_ID(), '_price', true)); ?></p>
            </a>
          </div>
          <?php
        }
        wp_reset_postdata();
      }
      ?>
    </div>
  </section>

  <!-- Shop Now Section -->
  <section class="full-screen shop-now">
    <div class="buttons">
      <a href="<?php echo esc_url(get_term_link('men', 'product_cat')); ?>" class="button">Shop Men's</a>
      <a href="<?php echo esc_url(get_term_link('women', 'product_cat')); ?>" class="button">Shop Women's</a>
      <a href="<?php echo esc_url(get_term_link('hats', 'product_cat')); ?>" class="button">Shop Hats</a>
    </div>
  </section>
</div>

<?php get_footer(); ?>
```

## Customizer Integration
```php
function theme_customizer($wp_customize) {
  $wp_customize->add_section('home_settings', array(
    'title' => 'Home Page Settings',
  ));
  $wp_customize->add_setting('hero_image');
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image', array(
    'label' => 'Hero Image',
    'section' => 'home_settings',
  )));
  $wp_customize->add_setting('gallery_images', array('default' => []));
  $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'gallery_images', array(
    'label' => 'Gallery Images',
    'section' => 'home_settings',
    'mime_type' => 'image',
    'multiple' => true,
  )));
}
add_action('customize_register', 'theme_customizer');
```

## Testing Checklist
- [ ] Hero image displays properly and is customizable
- [ ] Gallery images display and animate correctly
- [ ] Featured products query works and displays products
- [ ] Shop category links function correctly
- [ ] Snap scrolling works smoothly on all devices
- [ ] Animations perform well and don't cause performance issues
- [ ] Template is responsive across all device sizes 