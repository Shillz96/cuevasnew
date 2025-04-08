# Cart Page Template

## Overview
- **Goal:** Display the cart contents clearly with a minimalist design consistent with the Aether-inspired aesthetic.
- **Focus:** Simplicity, ease of use for quantity updates/removals, clear totals, and a prominent checkout button.
- **Layout:** Full-width, responsive table or list layout.

## Template Hierarchy
This template follows the WordPress template hierarchy for WooCommerce cart page:
1. `woocommerce/cart/cart.php` (primary template for the cart table)
2. `woocommerce/cart.php` (alternate template in woocommerce folder)
3. `page-cart.php` (custom page template)
4. `page.php` (general page template)
5. `singular.php` (template for all singular content)
6. `index.php` (ultimate fallback)

For additional cart components:
- Cart totals: `woocommerce/cart/cart-totals.php`
- Cross-sells: `woocommerce/cart/cross-sells.php`
- Empty cart: `woocommerce/cart/cart-empty.php`

## Template File
**Primary File**: `woocommerce/cart/cart.php`

## Layout Components (Aether-Inspired)
1.  **Cart Items:**
    *   Clean table or list format.
    *   Product thumbnail, title (linked), price, quantity selector (simple +/- buttons or input), line item total.
    *   Minimalist remove item button (e.g., 'X').
2.  **Cart Actions:**
    *   Update Cart button (if quantity adjustments don't auto-update via AJAX).
    *   Coupon code input field (cleanly integrated).
3.  **Cart Totals (Right Aligned or Below):**
    *   Clear breakdown: Subtotal, Shipping (with calculator link if applicable), Tax, Total.
    *   Prominent Proceed to Checkout button.
4.  **Cross-Sells (Optional, Below Totals):**
    *   Displayed in a clean grid, matching the shop page product card style.

## Core Functionality
- Display cart contents in a structured table
- Allow quantity adjustments
- Allow product removal
- Calculate and display totals
- Provide path to checkout
- Show cross-sell products
- **Design:** Implement Aether-inspired minimalist aesthetic: ample white space, clean lines, clear typography (Cinzel for headings, clean sans-serif for details), intuitive controls.

## Technical Requirements
1. **Structure**:
   - WooCommerce template override
   - Full-width layout
   - Responsive design for all screen sizes

2. **Animation**:
   - No complex animations required
   - Simple hover effects for buttons
   - Optional fade-in for cross-sells

3. **WordPress/WooCommerce Integration**:
   - Standard WooCommerce hooks for cart display
   - Cart update functionality
   - Cart total calculations
   - Cross-sell display

4. **Performance Considerations**:
   - Optimize ajax cart updates
   - Minimize unnecessary HTTP requests
   - Proper handling of cart sessions

5. **AJAX Updates (Optional but Recommended):** Implement AJAX updates for quantity changes and item removals for a smoother UX.

## Template Code Example
```php
<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<div class="woocommerce-cart-wrapper">
  <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <?php do_action('woocommerce_before_cart_table'); ?>

    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
      <thead>
        <tr>
          <th class="product-remove">&nbsp;</th>
          <th class="product-thumbnail">&nbsp;</th>
          <th class="product-name"><?php esc_html_e('Product', 'woocommerce'); ?></th>
          <th class="product-price"><?php esc_html_e('Price', 'woocommerce'); ?></th>
          <th class="product-quantity"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
          <th class="product-subtotal"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php do_action('woocommerce_before_cart_contents'); ?>

        <?php
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
          $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
          $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

          if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
            ?>
            <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

              <td class="product-remove">
                <?php
                echo apply_filters(
                  'woocommerce_cart_item_remove_link',
                  sprintf(
                    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                    esc_html__('Remove this item', 'woocommerce'),
                    esc_attr($product_id),
                    esc_attr($_product->get_sku())
                  ),
                  $cart_item_key
                );
                ?>
              </td>

              <td class="product-thumbnail">
                <?php
                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                if (!$product_permalink) {
                  echo $thumbnail; // PHPCS: XSS ok.
                } else {
                  printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                }
                ?>
              </td>

              <td class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                <?php
                if (!$product_permalink) {
                  echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                } else {
                  echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                }

                do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                // Meta data.
                echo wc_get_formatted_cart_item_data($cart_item);

                // Backorder notification.
                if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                  echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                }
                ?>
              </td>

              <td class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                <?php
                echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                ?>
              </td>

              <td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                <?php
                if ($_product->is_sold_individually()) {
                  $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                } else {
                  $product_quantity = woocommerce_quantity_input(
                    array(
                      'input_name'   => "cart[{$cart_item_key}][qty]",
                      'input_value'  => $cart_item['quantity'],
                      'max_value'    => $_product->get_max_purchase_quantity(),
                      'min_value'    => '0',
                      'product_name' => $_product->get_name(),
                    ),
                    $_product,
                    false
                  );
                }

                echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                ?>
              </td>

              <td class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                <?php
                echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                ?>
              </td>
            </tr>
            <?php
          }
        }
        ?>

        <?php do_action('woocommerce_after_cart_contents'); ?>
      </tbody>
    </table>

    <div class="cart-actions">
      <?php if (wc_coupons_enabled()) { ?>
        <div class="coupon">
          <label for="coupon_code"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
          <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
          <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_attr_e('Apply coupon', 'woocommerce'); ?></button>
          <?php do_action('woocommerce_cart_coupon'); ?>
        </div>
      <?php } ?>

      <button type="submit" class="button update-cart" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>

      <?php do_action('woocommerce_cart_actions'); ?>

      <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
    </div>
    
    <?php do_action('woocommerce_after_cart_table'); ?>
  </form>

  <div class="cart-collaterals">
    <?php
    /**
     * Cart collaterals hook.
     *
     * @hooked woocommerce_cross_sell_display
     * @hooked woocommerce_cart_totals - 10
     */
    do_action('woocommerce_cart_collaterals');
    ?>
  </div>
</div>

<?php do_action('woocommerce_after_cart'); ?>
```

## CSS Customization Notes (Aether-Inspired)
- **Layout:** Use `display: table` or modern CSS like Grid/Flexbox for the cart items layout. Ensure responsiveness.
- **Borders/Lines:** Use subtle, thin lines to separate items or sections, or rely on whitespace.
- **Thumbnails:** Ensure reasonable size and quality.
- **Quantity Input:** Style as a simple input field or use clean +/- buttons.
- **Buttons:** Use consistent, clean button styling for Update Cart, Apply Coupon, Proceed to Checkout.
- **Totals Section:** Clear alignment (often right-aligned), distinct visual separation for the final total.
- **Typography:** Consistent use of Cinzel/sans-serif fonts, appropriate sizes and weights.

## Testing Checklist
- [ ] Cart table displays correctly with all products
- [ ] Product images load and display properly
- [ ] Quantity adjustments work correctly
- [ ] Product removal functions properly
- [ ] Cart updates correctly when changing quantities
- [ ] Coupon system works if enabled
- [ ] Cart totals calculate and display correctly
- [ ] Proceed to checkout button works
- [ ] Layout is responsive on all device sizes
- [ ] Design matches Aether-inspired aesthetic (minimalist, clean typography, spacing).
- [ ] Quantity updates (manual or AJAX) work correctly.
- [ ] Item removal works correctly.
- [ ] Totals are calculated accurately.
- [ ] Checkout button proceeds to the correct page.
- [ ] Cross-sells (if active) display correctly using the shop grid style. 