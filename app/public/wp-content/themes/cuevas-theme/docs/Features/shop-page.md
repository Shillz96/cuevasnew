# Shop Page Template

## Overview
- **Goal:** Display WooCommerce products in a clean, minimalist grid layout inspired by [Aether Apparel](https://aetherapparel.com/collections/mens-sweatshirts) (example category page).
- **Focus:** Strong visual hierarchy, ample white space, clear typography, and intuitive navigation/filtering.
- **Layout:** Full-width, responsive grid.

## Template Hierarchy
This template follows the WordPress template hierarchy for WooCommerce:
1. `woocommerce/archive-product.php` (primary template for shop page)
2. `archive-product.php` (alternate template in theme root)
3. `woocommerce.php` (fallback for all WooCommerce content)
4. `archive.php` (general archive template)
5. `index.php` (ultimate fallback)

For product categories:
1. `woocommerce/taxonomy-product_cat-{category-slug}.php`
2. `taxonomy-product_cat-{category-slug}.php`
3. `woocommerce/taxonomy-product_cat.php`
4. `taxonomy-product_cat.php`
5. (then follow the regular archive hierarchy)

## Template File
**Primary File**: `woocommerce/archive-product.php`

## Layout Components
1.  **Page Header:** Minimalist category title (and potentially breadcrumbs).
2.  **Filtering/Sorting:** Prominent filter toggle button, potentially revealing filters in a sidebar or modal. Clear sorting options.
3.  **Product Grid:** Clean grid (e.g., 2-4 columns depending on screen size) with significant spacing between items. Product cards should be minimal (image, title, price, maybe color swatches on hover).
4.  **Pagination:** Simple, clear pagination controls.

## Core Functionality
- Full-width product display
- Filter products by attributes, price, etc.
- Sort products by various criteria
- Display product images, titles, and prices
- Quick view functionality (optional)
- **Design:** Implement Aether-inspired minimalist aesthetic: clean lines, generous white space, refined typography (using Cinzel primarily), and subtle hover effects.

## Technical Requirements
1. **Structure**:
   - WooCommerce template override
   - Full-width layout
   - Responsive grid design

2. **Animation**:
   - Subtle hover effects on product cards
   - No complex GSAP animations required

3. **WordPress/WooCommerce Integration**:
   - Standard WooCommerce hooks for product displays
   - Optional custom product query modifications
   - Category and attribute filtering

4. **Performance Considerations**:
   - Pagination for large product catalogs
   - Image optimization
   - Efficient product queries

5. **Filtering:** Implement a user-friendly filtering mechanism (e.g., slide-out sidebar or modal activated by a button) for attributes, price, etc.

## Template Code Example
```php
<?php
/**
 * The Template for displaying product archives, including the main shop page
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 */
do_action('woocommerce_before_main_content');
?>

<header class="woocommerce-products-header">
  <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
    <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
  <?php endif; ?>

  <?php
  /**
   * Hook: woocommerce_archive_description.
   */
  do_action('woocommerce_archive_description');
  ?>
</header>

<?php
if (woocommerce_product_loop()) {
  /**
   * Hook: woocommerce_before_shop_loop.
   */
  do_action('woocommerce_before_shop_loop');

  woocommerce_product_loop_start();

  if (wc_get_loop_prop('total')) {
    while (have_posts()) {
      the_post();

      /**
       * Hook: woocommerce_shop_loop.
       */
      do_action('woocommerce_shop_loop');

      wc_get_template_part('content', 'product');
    }
  }

  woocommerce_product_loop_end();

  /**
   * Hook: woocommerce_after_shop_loop.
   */
  do_action('woocommerce_after_shop_loop');
} else {
  /**
   * Hook: woocommerce_no_products_found.
   */
  do_action('woocommerce_no_products_found');
}

/**
 * Hook: woocommerce_after_main_content.
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
?>
```

## Customizing Individual Product Display
To customize how individual products appear in the grid, create or modify `woocommerce/content-product.php`:

```php
<?php
/**
 * The template for displaying product content within loops (Aether-inspired)
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
  return;
}
?>
<li <?php wc_product_class('product', $product); ?>>
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5 
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>
```

## CSS Customization Notes (Aether-Inspired)
- **Layout:** Use CSS Grid for `.products` container. Adjust `grid-template-columns` and `gap` for responsiveness.
- **Product Card (`.product`):** Minimal styling. No borders initially. Perhaps a subtle border/shadow on hover.
- **Image:** Ensure high quality. Consider object-fit properties.
- **Title/Price:** Use Cinzel font. Keep font sizes reasonable. Position below the image with clear spacing.
- **Add to Cart/Hover:** Keep Add-to-Cart button minimal or reveal on hover for a cleaner look.

## Testing Checklist
- [ ] Products display correctly in the grid layout
- [ ] Product filtering works properly
- [ ] Product sorting functions as expected
- [ ] Product images load properly and are optimized
- [ ] Layout is responsive and works on all device sizes
- [ ] WooCommerce hooks are maintained for compatibility
- [ ] Category pages follow the same design pattern
- [ ] Design matches Aether-inspired aesthetic (minimalist, clean lines, typography).
- [ ] Filtering mechanism is intuitive and matches design goals.
- [ ] Hover states on product cards are subtle and informative. 