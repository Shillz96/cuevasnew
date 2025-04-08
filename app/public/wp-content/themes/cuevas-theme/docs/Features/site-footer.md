# Site Footer

## Overview
- **Goal:** Provide consistent closing information, navigation links, and branding elements at the bottom of all pages *except* the homepage.
- **Design:** Clean, organized layout, often using multiple columns for widget areas/links. Consistent typography and color scheme matching the theme.
- **File:** `footer.php`

## Layout Components (Typical)
1.  **Widget Area(s):** Multiple columns displaying widgets (e.g., About text, Quick Links, Contact Info, Social Icons). Configured via WordPress Admin > Appearance > Widgets.
2.  **Footer Menu:** Secondary navigation menu (optional).
3.  **Copyright/Site Info:** Copyright text, privacy policy/terms links.

## Core Functionality
- Display widgetized content.
- Display footer navigation menu (if assigned).
- Display copyright and site information.
- **Homepage Exception:** The footer should *not* be displayed on the front page template (`front-page.php`).

## Technical Requirements
1.  **Structure:**
    *   Use semantic HTML (`<footer>`).
    *   Implement WordPress functions for dynamic sidebars/widgets (`dynamic_sidebar`) and menus (`wp_nav_menu`).
2.  **Styling (`assets/css/main.css` primarily):**
    *   Define background color, text colors, link styles appropriate for the footer.
    *   Use Grid or Flexbox to structure the columns for widgets/links.
    *   Style individual widgets consistently (headings, lists, text).
    *   Style the bottom copyright/site info section.
    *   Implement responsive styles for column stacking on smaller screens.
3.  **Homepage Hiding:**
    *   The logic to prevent display on the homepage can be done via CSS (`body.home footer { display: none; }`) or conditionally in `footer.php` (though CSS is often simpler).

## CSS Customization Notes
- **Spacing:** Ensure adequate padding within the footer and spacing between columns/widgets.
- **Typography:** Consistent font usage, appropriate sizes for links, headings, and text.
- **Responsiveness:** Test column stacking and readability on various screen sizes.

## Testing Checklist
- [ ] Footer displays correctly on all pages *except* the homepage.
- [ ] Footer is *not* visible on the homepage.
- [ ] Widgets display correctly within the footer columns.
- [ ] Footer menu (if used) displays and functions correctly.
- [ ] Copyright and site info are correct.
- [ ] Layout is responsive and columns stack appropriately on smaller devices.
- [ ] Styling (colors, fonts, spacing) is consistent with the overall theme. 