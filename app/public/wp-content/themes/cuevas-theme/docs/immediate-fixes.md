# Immediate Fixes Needed

This document lists issues identified that require immediate attention.

## Frontend/Styling Issues

1.  **Homepage Header White Bar on Refresh:**
    *   **Issue:** An unnecessary white bar appears briefly in the header area when the homepage is refreshed.
    *   **Potential Files:** `assets/css/main.css` (header styles), `assets/js/animations.js`, `assets/js/navigation.js`, `header.php`.

2.  **Homepage Shop Categories Button Icons:**
    *   **Issue:** Category icons are displayed within the buttons in the "Shop Categories" section. These icons should be removed, and the text should be centered within the buttons.
    *   **Potential Files:** `template-parts/homepage/shop-categories.php`, `assets/css/shop-categories.css`, `assets/css/main.css`.

3.  **Homepage Section Indicator Text:**
    *   **Issue:** The custom section indicators (likely dots or labels for navigation) on the homepage display generic text like "Section 1", "Section 2", etc. They should display meaningful labels like "Home", "Gallery", "Featured Products", "Shop Now".
    *   **Potential Files:** `inc/customizer.php` (if labels are set via Customizer), `template-parts/homepage/*` (if hardcoded), `assets/js/split-slideshow.js` or `assets/js/animations.js` (if generated dynamically).

4.  **WooCommerce Review Section Styling:**
    *   **Issue:** The WooCommerce reviews section/tab on the single product page is missing styling details.
    *   **Potential Files:** `assets/css/product-page.css`, `assets/css/main.css`, potentially an overridden template `woocommerce/single-product/tabs/reviews.php`.

5.  **Single Product Page Spacing:**
    *   **Issue:** Overall element spacing on the single product page needs adjustment for better visual appeal and natural flow.
    *   **Potential Files:** `assets/css/product-page.css`, `assets/css/main.css`, `woocommerce/single-product.php`, `woocommerce/content-single-product.php`.

6.  **Global Navigation Bar Size/Spacing:**
    *   **Issue:** The main site navigation bar (header) needs to be vertically smaller, and the text links within it need to be spaced more appropriately across the available width.
    *   **Potential Files:** `header.php`, `assets/css/main.css` (header styles), `assets/js/navigation.js`.

## Functional Issues / PHP Warnings

1.  **WooCommerce Product Gallery Warnings:**
    *   **Issue:** PHP warnings ("Trying to access array offset on value of type bool") appear on the single product page within the gallery area, originating from `wp-content/plugins/woocommerce/includes/wc-template-functions.php` on lines 1727, 1728, 1729, 1730, and 1750.
    *   **Cause:** This typically happens when the theme code interacts with WooCommerce gallery functions (like `woocommerce_get_gallery_image_html`) and provides invalid data (e.g., expecting an array of image attributes but getting `false`). This could be due to incorrect theme setup for image sizes, issues with product data, or problems in theme template overrides.
    *   **Potential Files (Theme Side):** `inc/woocommerce.php` (hooks modifying gallery), `functions.php` (image size registration/theme support), `woocommerce/single-product.php`, `woocommerce/content-single-product.php` (gallery template structure).
