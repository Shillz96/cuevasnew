here# Site Header (Navbar)

## Overview
- **Goal:** Provide consistent, clear site navigation and branding across all pages, with a specific transparent variation for the homepage.
- **Design:** Minimalist aesthetic, clean typography (Cinzel for branding, clear sans-serif for links), responsive behavior.
- **File:** `header.php`

## Layout Components
1.  **Site Branding:**
    *   Logo image.
    *   Site Title (optional, depending on logo).
2.  **Primary Navigation:**
    *   Main menu links (e.g., Men, Women, Explore).
    *   Dropdown menus for sub-categories (if applicable).
3.  **Navigation Extras (Right Side):**
    *   Search icon/link.
    *   User account icon/link.
    *   Cart icon/link (potentially with item count).
4.  **Mobile Navigation:**
    *   Hamburger menu toggle.
    *   Off-canvas or dropdown menu displaying primary navigation links.

## Core Functionality
- Display site logo and primary menu.
- Provide access to search, user account, and cart.
- Adapt responsively for mobile devices (hamburger menu).
- **Homepage Variation:** Header starts transparent and transitions to a solid background on scroll.
- **Other Pages:** Header has a solid background by default.

## Technical Requirements
1.  **Structure:**
    *   Use semantic HTML (`<header>`, `<nav>`).
    *   Implement WordPress menu functions (`wp_nav_menu`).
2.  **Styling (`assets/css/main.css` primarily):**
    *   Define default solid background and link styles.
    *   Define transparent background and appropriate link colors for the initial homepage state (`body.js-ready.home #page .site-header`).
    *   Define styles for the scrolled state (`.scrolled` class) - solid background, potentially reduced height/padding.
    *   Style navigation extras (icons, cart count).
    *   Implement responsive styles for mobile toggle and menu display.
3.  **JavaScript (`assets/js/navigation.js`, `assets/js/animations.js`):
    *   Toggle mobile menu visibility.
    *   Add/remove `.scrolled` class to header based on scroll position (handled in `animations.js`).

## CSS Customization Notes
- **Spacing:** Use Flexbox or Grid for layout within the header. Ensure appropriate spacing between logo, nav links, and extras.
- **Typography:** Consistent font usage (Cinzel/sans-serif).
- **Responsiveness:** Test thoroughly on various screen sizes.
- **Transitions:** Apply smooth CSS transitions for background color changes and potential height changes on scroll.

## Testing Checklist
- [ ] Header displays correctly on homepage (initially transparent, solid on scroll).
- [ ] Header displays correctly on other pages (solid background).
- [ ] Logo and navigation links are correct.
- [ ] Navigation extras (search, account, cart) function correctly.
- [ ] Cart count updates correctly (if implemented).
- [ ] Mobile hamburger menu appears at the correct breakpoint.
- [ ] Mobile menu toggles open/closed correctly.
- [ ] Mobile menu links are functional.
- [ ] Header layout is consistent and well-spaced across different pages and screen sizes. 