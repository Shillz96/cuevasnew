# Product Page Template

## Overview
- **Goal:** Display detailed product information with a clean, modern layout inspired by [Aether Apparel's product page](https://aetherapparel.com/products/pacer-jacket-fern-green).
- **Focus:** High-quality imagery, clear product options, structured technical details, and minimalist aesthetic.
- **Layout:** Typically a two-column layout on wider screens (gallery left, details right), stacking vertically on smaller screens.

## Template Hierarchy
This template follows the WordPress template hierarchy for WooCommerce single product pages:
1. `woocommerce/single-product-{product-type}.php` (specific product type template)
2. `woocommerce/single-product.php` (primary template for all products)
3. `single-product.php` (alternate template in theme root)
4. `single.php` (general single post template)
5. `singular.php` (template for all singular content)
6. `index.php` (ultimate fallback)

For variations and specific tabs:
- Product gallery: `woocommerce/single-product/product-image.php`
- Add to cart: `woocommerce/single-product/add-to-cart/{product-type}.php`
- Tabs: `woocommerce/single-product/tabs/`

## Template File
**Primary File**: `woocommerce/single-product.php`
**Content File**: `woocommerce/content-single-product.php` (often used within `single-product.php`)

## Layout Components (Aether-Inspired)
1.  **Product Gallery (Left Column):**
    *   Vertical thumbnails strip.
    *   Large main image display area.
    *   Zoom/lightbox functionality.
2.  **Product Information (Right Column):**
    *   Breadcrumbs (optional).
    *   Product Title (clear, prominent).
    *   Rating (subtle).
    *   Price.
    *   Color/Variant Swatches (if applicable).
    *   Size Selector.
    *   Add to Cart button (clear call to action).
    *   Short description or key selling points.
3.  **Below the Fold Sections:**
    *   Detailed Description / Technical Features (potentially using icons).
    *   Performance metrics (if applicable, like Aether's bars).
    *   Additional Details (materials, care, origin).
    *   Reviews (previously styled).
    *   Related Products / Pairs Well With / You May Also Like.

## Core Functionality
- Full-width product display
- Product image gallery with zoom
- Variable product options (sizes, colors, etc.)
- Add to cart functionality
- Product tabs for organized information
- GSAP animation for product image loading
- **Design:** Implement Aether-inspired minimalist aesthetic: generous white space, clean lines, Cinzel font for headings, clear hierarchy, high-quality visuals.
- **Gallery:** Vertical thumbnails, smooth transition to main image on thumbnail click/hover.

## Technical Requirements
1.  **Structure**:
    *   Use `woocommerce/single-product.php` and potentially `woocommerce/content-single-product.php`.
    *   Implement a CSS Grid or Flexbox layout for the main columns (gallery/details).
    *   Structure content below the fold logically.
2.  **Animation**:
    *   Subtle fade-in/load animation for main image.
    *   Smooth transitions for gallery interactions.
    *   Optional subtle animations for sections scrolling into view below the fold.
3.  **WordPress/WooCommerce Integration**:
    *   Override `woocommerce/single-product/product-image.php` to implement the vertical thumbnail gallery.
    *   Use standard hooks for product summary details (`woocommerce_single_product_summary`).
    *   Ensure variable product selectors (color, size) are styled consistently.
    *   Style tabs or accordion for description/details/reviews below the fold.

## Template Code Example
```php
<?php
/**
 * The Template for displaying all single products
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 */
do_action('woocommerce_before_main_content');

while (have_posts()) :
  the_post();
  
  global $product;
  ?>
  <div class="single-product-wrapper">
    <div class="product-gallery-section">
      <?php
      /**
       * Hook: woocommerce_before_single_product_summary.
       * 
       * @hooked woocommerce_show_product_sale_flash - 10
       * @hooked woocommerce_show_product_images - 20
       */
      do_action('woocommerce_before_single_product_summary');
      ?>
    </div>

    <div class="product-details-section">
      <?php
      /**
       * Hook: woocommerce_single_product_summary.
       * 
       * @hooked woocommerce_template_single_title - 5
       * @hooked woocommerce_template_single_rating - 10
       * @hooked woocommerce_template_single_price - 10
       * @hooked woocommerce_template_single_excerpt - 20
       * @hooked woocommerce_template_single_add_to_cart - 30
       * @hooked woocommerce_template_single_meta - 40
       * @hooked woocommerce_template_single_sharing - 50
       */
      do_action('woocommerce_single_product_summary');
      ?>
    </div>
  </div>

  <?php
  /**
   * Hook: woocommerce_after_single_product_summary.
   * 
   * @hooked woocommerce_output_product_data_tabs - 10
   * @hooked woocommerce_upsell_display - 15
   * @hooked woocommerce_output_related_products - 20
   */
  do_action('woocommerce_after_single_product_summary');

endwhile; // end of the loop.

/**
 * Hook: woocommerce_after_main_content.
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
?>
```

## CSS Customization Notes (Aether-Inspired)
- **Layout:** Use Grid/Flexbox for main two-column layout. Ensure proper stacking on mobile.
- **Gallery:** Style vertical thumbnails, active states. Ensure main image container is adequately sized.
- **Details Column:** Align text left. Use ample spacing between title, price, variants, button. Style size/color selectors cleanly (e.g., simple boxes or circles).
- **Buttons:** Clean, clear button styles.
- **Below Fold:** Use clear headings (Cinzel font), well-spaced content sections. Consider thin borders or background variations to separate sections.
- **Typography:** Use Cinzel for headings, Raleway or a clean sans-serif for body text. Maintain consistent font sizes and weights.

## GSAP Animation
- Apply subtle `gsap.from()` to the main gallery image or the entire gallery container on load.

## Additional WooCommerce Customizations
To customize specific elements of the product page, you can override additional templates:

### Product Gallery
Create `woocommerce/single-product/product-image.php` to customize the gallery layout.

### Add to Cart Button
Create `woocommerce/single-product/add-to-cart/simple.php` (or other product types) to customize the add to cart experience.

### Product Tabs
Create `woocommerce/single-product/tabs/description.php`, `tabs/additional-information.php`, etc. to customize tab content.

## Testing Checklist
- [ ] Product gallery displays and functions correctly
- [ ] GSAP animation plays smoothly
- [ ] Product information is displayed clearly
- [ ] Variable product options work correctly
- [ ] Add to cart functionality works properly
- [ ] Product tabs display and function correctly
- [ ] Related products are displayed appropriately
- [ ] Layout is responsive across all device sizes
- [ ] Vertical thumbnail gallery works correctly (click/hover, active states)
- [ ] Layout matches Aether-inspired two-column structure on desktop, stacks correctly on mobile
- [ ] Color/Size selectors are styled clearly and function correctly
- [ ] Below-the-fold sections (details, performance, etc.) are structured and styled correctly
- [ ] Overall aesthetic is clean, minimalist, with good typography and spacing 