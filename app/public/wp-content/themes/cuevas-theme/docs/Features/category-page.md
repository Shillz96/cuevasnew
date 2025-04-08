# Product Category Page

## Overview
This page displays products belonging to a specific WooCommerce category. It shares the same core templates and design principles as the main shop page.

## Design Goal
Implement the Aether-inspired minimalist grid layout and filtering system as defined in [shop-page.md](./shop-page.md).

## Template Hierarchy
1. `woocommerce/taxonomy-product_cat-{category-slug}.php`
2. `taxonomy-product_cat-{category-slug}.php`
3. `woocommerce/taxonomy-product_cat.php`
4. `taxonomy-product_cat.php`
5. `woocommerce/archive-product.php` (Fallback to shop template)
6. `archive.php`
7. `index.php`

## Key Considerations
- The header section should display the category title and potentially the description (if provided).
- Ensure the filtering and sorting options function correctly within the context of the current category.
- The product grid and individual product card display should match the styles defined for the main shop page.

## Implementation Details
Refer to [shop-page.md](./shop-page.md) for details on layout, components, template code examples (`archive-product.php`, `content-product.php`), CSS customization, and testing checklists. Ensure these guidelines are applied consistently to category archive pages. 