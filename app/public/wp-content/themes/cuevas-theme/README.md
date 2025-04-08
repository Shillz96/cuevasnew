# Cuevas Western Wear - WordPress Theme

A modern, responsive WordPress theme for Cuevas Western Wear e-commerce store. Designed for seamless WooCommerce integration with a focus on product display and user experience.

## Theme Structure

```
theme/
├── assets/
│   ├── css/
│   │   ├── main.css              # Main stylesheet (imports others)
│   │   ├── homepage.css          # Homepage specific styles (conditional)
│   │   ├── split-slideshow.css   # Hero slideshow styles (conditional)
│   │   ├── product-card.css      # Product card component styles (global)
│   │   ├── product-grid.css      # Product grid layout styles (global & specific)
│   │   ├── product-page.css      # Single product page layout styles (conditional)
│   │   ├── shop-categories.css   # Shop categories section styles (conditional)
│   │   ├── brand-elements.css    # Brand specific styles
│   │   ├── product-badges.css    # Product badge styles
│   │   ├── sidebar.css           # Sidebar styles
│   │   ├── team-section.css      # Team section styles (if applicable)
│   │   ├── trust-badges.css      # Trust badge styles
│   │   ├── western-icons.css     # Western icon styles
│   │   ├── widgets/              # Styles for custom widgets
│   │   │   ├── deal-timer.css
│   │   │   ├── featured-product.css
│   │   │   ├── heritage-story-blocks.css
│   │   │   ├── instagram-feed.css # (Actual file if it exists, or remove if not)
│   │   │   └── western-style-guide.css
│   │   ├── animations.css        # Base animation styles (if exists)
│   │   └── woocommerce.css       # WooCommerce specific overrides (if exists)
│   ├── js/
│   │   ├── animations.js         # Main animation scripts (GSAP init, general)
│   │   ├── navigation.js         # Navigation functionality
│   │   ├── split-slideshow.js    # Homepage slideshow script (conditional)
│   │   ├── about-animations.js   # About page animations script (conditional)
│   │   ├── product-page.js       # Single Product page interactions script (conditional)
│   │   └── customizer.js         # Theme customizer preview script
│   ├── images/                   # Theme images (e.g., 404 image, placeholders)
│   └── img/                      # Theme SVG images
│       ├── rope-border.svg
│       ├── western-corner.svg
│       └── western-pattern.svg
├── inc/
│   ├── customizer.php            # Theme customization options
│   ├── template-tags.php         # Template helper functions
│   └── woocommerce.php           # WooCommerce integration & hooks
├── template-parts/               # Reusable template parts
│   ├── content.php               # Default content template for posts
│   ├── content-none.php          # No content found template
│   ├── content-page.php          # Default content template for pages
│   ├── content-search.php        # Content template for search results
│   ├── content-single.php        # Content template for single posts
│   ├── product-card.php          # Template part for product cards (if used)
│   └── homepage/                 # Homepage section templates
│       ├── hero-section.php      # Hero section
│       ├── split-slideshow.php   # Slideshow component
│       ├── products-grid.php     # Homepage products grid section
│       ├── shop-categories.php   # Shop categories section
│       └── featured-products.php # Featured products section
├── woocommerce/                  # WooCommerce template overrides
│   ├── archive-product.php       # Shop / Product Archive template
│   ├── content-product.php       # Product display in loops (uses hooks)
│   ├── content-single-product.php # Main content for single product page
│   └── single-product.php        # Single product page template shell
├── functions.php                 # Theme functions, setup, script/style enqueueing
├── style.css                     # Theme metadata (Required by WordPress)
├── index.php                     # Main fallback template file
├── header.php                    # Site header
├── footer.php                    # Site footer
├── sidebar.php                   # Sidebar template
├── front-page.php                # Homepage template
├── page.php                      # Default page template
├── page-about.php                # About page template (custom)
├── single.php                    # Single post template
├── archive.php                   # Default Archive template (posts, etc.)
├── search.php                    # Search results template
└── 404.php                       # 404 error page template
```

## Theme Features

- **Modern Product Card Design**: Clean, visually appealing product cards driven by WooCommerce hooks.
- **Custom Homepage Sections**: Configurable sections for Hero, Slideshow, Product Grid, Categories.
- **Single Product Page Layout**: Custom layout for product details page.
- **Responsive Design**: Adapts to different screen sizes.
- **GSAP Animations**: Smooth animations for enhanced user experience.
- **Theme Customizer Options**: Settings for navigation, footer, and homepage sections.
- **WooCommerce Integration**: Overridden templates and custom hooks for seamless shop experience.

## ScrollTrigger Animations

The theme incorporates GSAP ScrollTrigger for dynamic scroll-based animations:

### Home Page Animations
- **Hero Section**: Text elements fade in with staggered animation as you scroll
- **Header Transformation**: Header shrinks and becomes more compact when scrolling
- **Featured Products/Product Grid**: Products animate into view with a staggered sequence (if configured)
- **Category Showcase**: Parallax effect or reveal animations on the Shop Categories section.

### Implementation Details

Animations are primarily controlled within `assets/js/animations.js` and potentially page-specific files like `assets/js/about-animations.js` using GSAP and ScrollTrigger.

```javascript
// Example ScrollTrigger implementation for the header
gsap.to(".site-header", {
  scrollTrigger: {
    trigger: "body",
    start: "top top",
    end: "50px top",
    scrub: true
  },
  // ... properties to animate (e.g., height, background)
});

// Example product reveal animation (applies generally)
gsap.from(".product-card", {
  scrollTrigger: {
    trigger: ".products", // Target the grid container
    start: "top 80%",
    toggleActions: "play none none none",
    stagger: 0.1
  },
  y: 50,
  opacity: 0,
  duration: 0.8,
});
```

## WordPress Integration Guide

### 1. Theme Setup

The theme follows standard WordPress structure. Activate the theme through the Appearance > Themes menu in the WordPress admin.

### 2. WooCommerce Templates

The following WooCommerce templates are overridden in the `woocommerce/` folder:

- `archive-product.php`
- `content-product.php`
- `content-single-product.php`
- `single-product.php`

Customizations to the product loop display are primarily handled via hooks in `inc/woocommerce.php` acting upon `content-product.php`.

### 3. Setup WooCommerce Support

Theme support for WooCommerce is declared in `functions.php`:

```php
function cuevas_woocommerce_setup() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'cuevas_woocommerce_setup');
```

### 4. Enqueue Scripts/Styles

All scripts and styles are enqueued via the `cuevas_scripts` function in `functions.php`. Key assets include:

**CSS:**
- `main.css` (Global styles)
- `woocommerce.css` (WooCommerce overrides, conditional)
- `product-card.css` (General product card styles)
- `product-grid.css` (Grid layouts)
- `product-page.css` (Single product page styles, conditional)
- `animations.css` (Base animation styles, conditional)
- **Homepage Specific (conditional):** `homepage.css`, `split-slideshow.css`, `shop-categories.css`
- Google Fonts
- Slick Slider CSS

**JavaScript:**
- jQuery (WordPress dependency)
- `navigation.js` (Main navigation)
- `animations.js` (Main animations, GSAP init)
- GSAP Core, ScrollTrigger, ScrollToPlugin
- Slick Slider JS
- **Conditional:** `split-slideshow.js`, `about-animations.js`, `product-page.js`
- `customizer.js` (For Customizer preview)

See the `cuevas_scripts` function in `functions.php` for detailed logic and dependencies.

## Customization Options

Theme options are available in the WordPress Customizer (Appearance > Customize):

- **Homepage Sections:** Configure Hero, Gallery, Featured Products, Shop Categories sections.
- **Navigation:** Customize background/text color, homepage transparency.
- **Footer Settings:** Edit About text, contact details, social media links.
- Standard WordPress options (Site Identity, Menus, Widgets, etc.)

## Browser Compatibility

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Performance Considerations

- CSS/JS files are loaded conditionally where possible.
- Use `filemtime()` for cache-busting versioning on local assets.
- Consider using a caching plugin and image optimization for production environments.

## Credits

- Font Awesome (ensure it's loaded if icons are used)
- GSAP for animations
- Slick Carousel for sliders
- Google Fonts for typography 