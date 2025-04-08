# Split Slideshow Feature

## Overview
The Split Slideshow is a visually striking, full-screen, vertical scrolling slideshow that divides the screen into two halves. It features synchronized text animations and smooth transitions, providing an engaging western-themed introduction to the Cuevas Western Wear site.

## Technical Implementation

### File Structure
```
cuevas-theme/
├── assets/
│   ├── css/
│   │   └── split-slideshow.css         # Slideshow styling
│   ├── js/
│   │   └── split-slideshow.js          # Slideshow functionality
│   └── images/                         # Default slideshow images
│       ├── slide-1.jpg
│       ├── slide-2.jpg
│       ├── slide-3.jpg
│       └── slide-4.jpg
└── template-parts/
    └── homepage/
        └── split-slideshow.php         # Template part for slideshow
```

### Dependencies
- jQuery (WordPress core)
- Slick Slider (1.8.1)
- GSAP (for potential animation enhancements)

### Integration
The slideshow is:
1. Loaded only on the homepage (front-page.php)
2. Conditionally includes CSS and JS only on the front page
3. Works with ACF for content management or falls back to defaults

### Content Management
Slideshow content can be managed in one of two ways:
1. **Advanced Custom Fields (preferred)**: Create a repeater field called `slideshow_slides` with sub-fields:
   - `slide_image` (Image field)
   - `slide_text` (Text field)
2. **Default Images**: If ACF is not used, default images and text will be displayed

## Design Specifications

### Visual Elements
- **Split Screen**: Left and right panels showing synchronized but mirrored content
- **Vertical Scrolling**: Uses mouse wheel or touch swipe for vertical navigation
- **Text Overlay**: Large, uppercase typography centered on screen
- **Navigation Dots**: Minimalist indicators on right side

### Styling
- **Typography**: 
  - Font: Playfair Display for text
  - Size: 80px on desktop, 40px on mobile
  - Style: Uppercase with 20px letter spacing
- **Colors**: 
  - Background: Dark (#110101)
  - Text: Brand color from theme variables
  - Border: Accent color from theme variables
- **Animations**:
  - Smooth cubic-bezier timing function
  - Synchronized sliding motion

### Responsive Behavior
- **Desktop**: Full split-screen experience
- **Mobile**: Maintains vertical scrolling with adjusted typography size

## Usage Instructions

### For Developers
1. The slideshow is automatically included on the homepage via `front-page.php`
2. Customize transition speed in the JS file
3. Adjust styling in the CSS file

### For Content Editors
If using ACF:
1. Navigate to the Homepage in the WordPress admin
2. Find the "Slideshow Slides" repeater field
3. Add/remove/reorder slides as needed
4. For each slide, upload an image and set the text overlay

## Performance Considerations
- Images should be optimized for web (recommended size: 1920×1080px)
- Large, high-quality images may impact load time on slower connections
- Consider preloading critical images for smoother initial display 