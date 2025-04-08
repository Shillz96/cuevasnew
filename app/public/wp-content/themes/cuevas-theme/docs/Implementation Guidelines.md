# Implementation Guidelines

## WordPress Template Hierarchy

### Overview
The WordPress Template Hierarchy is a system that determines which PHP template file is used to display a page. Understanding this hierarchy is essential for developing custom themes effectively. This guide outlines the implementation details for the Cuevas Western Wear theme.

### File Structure
Maintain the following file structure for template files:

```
cuevas-theme/
├── index.php              # Ultimate fallback for all pages
├── style.css              # Theme metadata and basic styles
├── functions.php          # Theme setup and core functionality
├── header.php             # Global header template
├── footer.php             # Global footer template
├── front-page.php         # Custom home page template
├── page.php               # Generic page template
├── single.php             # Single post template
├── archive.php            # Archive template (categories, tags, etc.)
├── 404.php                # Page not found template
├── search.php             # Search results template
├── sidebar.php            # Sidebar template (if used)
├── woocommerce/           # WooCommerce template overrides
│   ├── archive-product.php
│   ├── single-product.php
│   ├── content-product.php
│   ├── cart/
│   │   └── cart.php
│   └── ...
└── template-parts/        # Reusable template parts
    ├── content/
    ├── header/
    ├── footer/
    └── ...
```

### Coding Standards

#### PHP
- Follow WordPress PHP Coding Standards
- Use proper escaping functions (`esc_html`, `esc_url`, etc.)
- Implement proper sanitization for user input
- Use template tags instead of global variables when possible
- Include text domain for translations

```php
// Example of proper template implementation
<?php
/**
 * Template Name: Custom Page Template
 *
 * @package Cuevas_Theme
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php echo esc_html( get_the_title() ); ?></h1>
            </header>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
        <?php
    endwhile;
    ?>
</main>

<?php
get_footer();
```

#### CSS
- Use a modular approach with separate files for different components
- Follow BEM naming convention
- Use CSS custom properties for theme colors and other values
- Implement mobile-first responsive design

```css
:root {
    --color-background: #F5F5DC;
    --color-text: #3E2723;
    --color-accent: #8B4513;
    --color-button: #A52A2A;
    --color-button-hover: #D2691E;
}

.product-card {
    background-color: var(--color-background);
    color: var(--color-text);
    border: 1px solid var(--color-accent);
}

.product-card__title {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
}

.product-card__price {
    color: var(--color-button);
    font-weight: bold;
}
```

#### JavaScript
- Use ES6+ syntax and features
- Organize code in modular components
- Properly initialize GSAP animations
- Ensure proper event handling

```javascript
document.addEventListener('DOMContentLoaded', function() {
    // Register GSAP plugins
    gsap.registerPlugin(ScrollTrigger);
    
    // Initialize animations
    initHomePageAnimations();
    initProductAnimations();
    
    // Set up event listeners
    document.querySelector('.hamburger').addEventListener('click', toggleMenu);
});

function initHomePageAnimations() {
    if (document.querySelector('.hero-section')) {
        gsap.from('.hero-content', {
            opacity: 0,
            y: 50,
            duration: 1,
            ease: 'power3.out'
        });
    }
}

function toggleMenu() {
    const menu = document.querySelector('.menu');
    menu.classList.toggle('open');
    
    gsap.to(menu, {
        right: menu.classList.contains('open') ? 0 : '-100%',
        duration: 0.5,
        ease: 'power2.inOut'
    });
}
```

### Template Hierarchy Implementation

#### Home Page
- Use `front-page.php` as the primary template
- Implement full-width layout with CSS
- Include GSAP animations for scrolling sections
- Query for featured products using WooCommerce integration

#### Shop Page
- Override `woocommerce/archive-product.php`
- Maintain WooCommerce hooks for compatibility
- Customize product grid with CSS
- Ensure responsive layout across all devices

#### Product Page
- Override `woocommerce/single-product.php`
- Customize product display while maintaining WooCommerce functionality
- Add subtle GSAP animations for product gallery
- Ensure proper display of variable products

#### Cart Page
- Override `woocommerce/cart/cart.php`
- Customize cart layout while keeping WooCommerce functionality
- Style cart elements to match the theme
- Ensure responsive behavior for smaller screens

### GSAP Implementation Guidelines

#### Loading GSAP Libraries
```php
function cuevas_enqueue_scripts() {
    // GSAP Core
    wp_enqueue_script('gsap-core', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js', array(), null, true);
    
    // GSAP ScrollTrigger
    wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js', array('gsap-core'), null, true);
    
    // Theme scripts
    wp_enqueue_script('cuevas-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('gsap-core', 'gsap-scrolltrigger'), null, true);
}
add_action('wp_enqueue_scripts', 'cuevas_enqueue_scripts');
```

#### Performance Best Practices
- Use `gsap.set()` for initial states instead of CSS when possible
- Leverage the ScrollTrigger plugin efficiently
- Use `will-change` CSS property sparingly
- Consider lazy-loading animations for off-screen elements
- Implement `matchMedia()` to adjust animations based on screen size

### WooCommerce Integration Guidelines

#### Template Overriding
- Copy WooCommerce templates to `your-theme/woocommerce/` directory
- Modify templates while maintaining WooCommerce hooks
- Use `wc_get_template_part()` for template parts
- Keep template structure for compatibility with future WooCommerce updates

#### Custom Functionality
- Add custom functionality via hooks instead of directly modifying templates when possible
- Use WooCommerce-specific hooks for product displays
- Ensure cart functionality works correctly
- Test thoroughly with different product types

### Testing Methodology
- Test templates across different content types
- Verify responsive behavior on multiple device sizes
- Check WooCommerce integration with various product configurations
- Ensure GSAP animations perform well on various devices
- Validate code against WordPress coding standards

### Version Control
- Use meaningful commit messages
- Organize work in feature branches
- Document template modifications
- Keep track of WooCommerce version compatibility

### Documentation
- Document custom template usage in theme README
- Include information about WooCommerce template overrides
- Provide details about GSAP animations and how to customize them
- Maintain a changelog for template modifications 