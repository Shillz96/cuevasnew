/**
 * Main Animations for Cuevas Western Wear Theme
 * Handles scrolling behavior, entrance animations, and section transitions
 */

// Add this class immediately
document.body.classList.add('js-ready');
console.log('js-ready class added to body');

// GSAP Plugin Registration (if not already done)
gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

console.log('GSAP and plugins registered');

// Global Animation Settings (Optional)
// gsap.defaults({ease: "power2.inOut"});

document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing animations and scrolling behavior');
    
    // Add CSS for smooth scrolling transitions - keep scrollbar visible but simpler
    const style = document.createElement('style');
    style.textContent = `
        html {
            scrollbar-width: thin;
        }
        
        body {
            overflow-y: auto !important; /* Always show scrollbar */
        }
        
        .is-scrolling {
            scroll-behavior: smooth;
        }
        
        .split-slideshow.transitioning {
            pointer-events: none !important;
        }
        
        /* Hide ALL non-current indicators */
        #fp-nav, 
        .fp-slidesNav,
        #fp-nav ul li, 
        .fp-slidesNav ul li,
        .section-nav-indicators:not(.current-indicators) {
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
        }
        
        /* Only our indicators should be visible */
        .current-indicators.our-dot-indicators {
            display: flex !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
    `;
    document.head.appendChild(style);
    
    // Remove all existing indicators
    removeAllPageIndicators();
    
    // Check if GSAP exists before trying to run animations
    if (typeof gsap === 'undefined') {
        console.warn('GSAP not loaded, animations disabled');
        return;
    }
    
    // Register necessary plugins
    initializePlugins();
    
    // Initialize page behavior based on page type
    if (document.body.classList.contains('home') || document.body.classList.contains('page-template-front-page')) {
        // Only run on homepage/front page
        console.log('Homepage detected, initializing section scrolling');
        initializePageScrolling();
    } else {
        // For all other pages
        console.log('Regular page detected, initializing basic animations');
        initializeBasicAnimations();
    }
    
    // Initialize common animations
    initializeHeaderBehavior();
    initializeEntranceAnimations();
    initializeSmoothScroll();
    
    // Remove hover animations handled by CSS now
    /*
    const shopButtons = document.querySelectorAll('#shop-categories a');
    
    shopButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'rgba(139, 69, 19, 1)';
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 8px 15px rgba(0, 0, 0, 0.4)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.backgroundColor = 'rgba(139, 69, 19, 0.8)';
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 4px 10px rgba(0, 0, 0, 0.3)';
        });
    });
    */
});

/**
 * Aggressively remove all indicators from the page
 */
function removeAllPageIndicators() {
    console.log('Removing all page indicators');
    
    // Remove FullPage.js navigation elements if they exist
    const fpNavs = document.querySelectorAll('#fp-nav, .fp-slidesNav');
    fpNavs.forEach(nav => nav.remove());
    
    // Remove all existing section indicators EXCEPT our custom one
    const indicators = document.querySelectorAll('.section-nav-indicators:not(#custom-page-indicators)');
    indicators.forEach(indicator => indicator.remove());
    
    // Set timeout to remove any that might be added later by plugins
    setTimeout(function() {
        const laterFpNavs = document.querySelectorAll('#fp-nav, .fp-slidesNav');
        laterFpNavs.forEach(nav => nav.remove());
    }, 500);
}

/**
 * Register GSAP plugins
 */
function initializePlugins() {
    // Register ScrollTrigger plugin if available
    if (typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
        console.log('ScrollTrigger registered successfully');
    } else {
        console.warn('ScrollTrigger not available, some animations disabled');
    }
    
    // Register ScrollToPlugin if available
    if (typeof ScrollToPlugin !== 'undefined') {
        gsap.registerPlugin(ScrollToPlugin);
        console.log('ScrollToPlugin registered successfully');
    } else {
        console.warn('ScrollToPlugin not available, smooth scrolling may not work');
    }
}

/**
 * Initialize smooth scrolling and section snapping for the homepage
 */
function initializePageScrolling() {
    // Get all homepage sections
    const sections = document.querySelectorAll('.homepage-section');
    
    // Hide footer if present (as requested)
    const footer = document.querySelector('.site-footer');
    if (footer) {
        footer.style.display = 'none';
    }
    
    // Exit if no sections found
    if (!sections || sections.length < 2) {
        console.warn('Not enough sections found for section scrolling');
        return;
    }
    
    console.log(`Found ${sections.length} homepage sections`);
    
    // Find the slideshow section specifically
    const slideshowSection = document.querySelector('.split-slideshow');
    const slideshowIndex = slideshowSection ? Array.from(sections).indexOf(slideshowSection) : -1;
    
    console.log(`Slideshow is section #${slideshowIndex + 1}`);
    
    // Only create section indicators if our custom one doesn't already exist
    let indicatorContainer = document.querySelector('#custom-page-indicators');
    if (!indicatorContainer) {
        indicatorContainer = createSectionIndicators(sections);
    }
    
    // Setup section navigation system
    setupSectionNavigation(sections, slideshowIndex, indicatorContainer);
    
    // Setup keyboard navigation
    setupKeyboardNavigation();
    
    // Setup touch/swipe navigation for mobile
    setupTouchNavigation();
}

/**
 * Setup section navigation system
 */
function setupSectionNavigation(sections, slideshowIndex, indicatorContainer) {
    // Lockout mechanism - safer than isScrolling flag
    let scrollLock = false;
    
    // Determine current section based on scroll position
    function getCurrentSectionIndex() {
        const scrollPosition = window.scrollY;
        
        for (let i = 0; i < sections.length; i++) {
            const section = sections[i];
            const sectionTop = section.offsetTop - 100; // Some tolerance
            const sectionBottom = sectionTop + section.offsetHeight;
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
                return i;
            }
        }
        
        return 0; // Default to first section if not found
    }
    
    // Function to move to a specific section
    window.moveToSection = function(index) {
        if (index < 0 || index >= sections.length || scrollLock) return;
        
        console.log(`Moving to section ${index + 1}`);
        
        // Set lock to prevent multiple scrolls
        scrollLock = true;
        
        // Update indicator
        updateActiveSection(index);
        
        // Simple approach - scroll into view with GSAP
                    gsap.to(window, {
                        duration: 0.5, 
            scrollTo: {
                y: sections[index],
                offsetY: 0,
            },
            ease: "power2.out",
            onComplete: function() {
                // Release lock after animation completes
                setTimeout(function() {
                    scrollLock = false;
                    
                    // If we moved to slideshow section, reset it to first slide
                    if (index === slideshowIndex && window.splitSlideshow && typeof window.splitSlideshow.goToSlide === 'function') {
                                window.splitSlideshow.goToSlide(0);
                            }
                }, 200);
            }
        });
    };
    
    // Function to move to next section
    window.moveToNextSection = function() {
        if (scrollLock) return;
        const currentIndex = getCurrentSectionIndex();
        if (currentIndex < sections.length - 1) {
            moveToSection(currentIndex + 1);
        }
    };
    
    // Function to move to previous section
    window.moveToPrevSection = function() {
        if (scrollLock) return;
        const currentIndex = getCurrentSectionIndex();
        if (currentIndex > 0) {
            moveToSection(currentIndex - 1);
        }
    };
    
    // Update active section indicator
    function updateActiveSection(index) {
        if (!indicatorContainer) return;
        
        const indicators = indicatorContainer.querySelectorAll('.section-indicator');
        
        indicators.forEach(function(indicator, i) {
            if (i === index) {
                indicator.classList.add('active');
            } else {
                indicator.classList.remove('active');
            }
        });
    }
    
    // Handle wheel-based scrolling - simplified approach
    function handleWheel(event) {
        // Skip if locked or in slideshow
        if (scrollLock) {
            event.preventDefault();
            return;
        }
        
        // Get current section
        const currentSectionIndex = getCurrentSectionIndex();
        
        // Special handling for slideshow section
        if (slideshowIndex >= 0 && currentSectionIndex === slideshowIndex) {
            // Let the slideshow handle its own internal scrolling
            return;
        }
        
        // Simple approach - just check delta direction
        if (event.deltaY > 0) {
            // Scrolling down - go to next section
            if (currentSectionIndex < sections.length - 1) {
                event.preventDefault();
                moveToSection(currentSectionIndex + 1);
            }
        } else if (event.deltaY < 0) {
            // Scrolling up - go to previous section
            if (currentSectionIndex > 0) {
                event.preventDefault();
                moveToSection(currentSectionIndex - 1);
            }
        }
    }
    
    // Simple wheel event listener
    window.addEventListener('wheel', handleWheel, { passive: false });
    
    // Update indicators on scroll - use throttled approach for better performance
    let lastKnownScrollPosition = 0;
    let ticking = false;
    
    window.addEventListener('scroll', function() {
        lastKnownScrollPosition = window.scrollY;
        
        if (!ticking && !scrollLock) {
            window.requestAnimationFrame(function() {
                updateActiveSection(getCurrentSectionIndex());
                ticking = false;
            });
            ticking = true;
        }
    });
    
    // Initial update of active section
    updateActiveSection(getCurrentSectionIndex());
}

/**
 * Setup keyboard navigation for section scrolling
 */
function setupKeyboardNavigation() {
    function handleKeyDown(event) {
        // Ignore if in input field
        if (event.target.tagName.toLowerCase() === 'input' || 
            event.target.tagName.toLowerCase() === 'textarea' || 
            event.target.isContentEditable) {
            return;
        }
        
        // Skip if already animating
        if (document.body.classList.contains('is-animated-scrolling')) {
            return;
        }
        
        // Arrow down or Page Down
        if (event.key === 'ArrowDown' || event.key === 'PageDown') {
            event.preventDefault();
            window.moveToNextSection();
        }
        
        // Arrow up or Page Up
        if (event.key === 'ArrowUp' || event.key === 'PageUp') {
            event.preventDefault();
            window.moveToPrevSection();
        }
        
        // Home key - go to first section
        if (event.key === 'Home') {
            event.preventDefault();
            window.moveToSection(0);
        }
        
        // End key - go to last section
        if (event.key === 'End') {
            event.preventDefault();
            const sections = document.querySelectorAll('.homepage-section');
            window.moveToSection(sections.length - 1);
        }
    }

    // Remove any existing handlers then add ours
    const keyDownHandlerRef = function(e) { handleKeyDown(e); };
    document.removeEventListener('keydown', keyDownHandlerRef);
    document.addEventListener('keydown', keyDownHandlerRef);
}

/**
 * Setup touch/swipe navigation for mobile devices
 */
function setupTouchNavigation() {
    // Only initialize if we have jQuery
    if (typeof jQuery === 'undefined') return;
    
    // Remove existing handlers first
    jQuery('body').off('touchstart.sectionNav touchend.sectionNav');
    
    let touchStartY = 0;
    const minSwipeDistance = 100; // Minimum distance required for a swipe
    
    // Add swipe event handlers to body
    jQuery('body').on('touchstart.sectionNav', function(event) {
        // Skip if in animated scrolling mode
        if (document.body.classList.contains('is-animated-scrolling')) return;
        
        // Store the start position
        touchStartY = event.originalEvent.touches[0].clientY;
    });
    
    jQuery('body').on('touchend.sectionNav', function(event) {
        // Skip if in animated scrolling mode
        if (document.body.classList.contains('is-animated-scrolling')) return;
        
        // Store the end position
        const touchEndY = event.originalEvent.changedTouches[0].clientY;
        
        // Calculate the distance
        const swipeDistance = touchEndY - touchStartY;
        
        // Check if the swipe was long enough
        if (Math.abs(swipeDistance) < minSwipeDistance) return;
        
        // Handle the swipe
        if (swipeDistance > 0) {
            // Swipe down - go to previous section
            window.moveToPrevSection();
        } else {
            // Swipe up - go to next section
            window.moveToNextSection();
        }
    });
}

/**
 * Create visual indicators for sections
 * Returns the indicator container for later reference
 */
function createSectionIndicators(sections) {
    // Create container for indicators
    const indicatorContainer = document.createElement('div');
    indicatorContainer.className = 'section-nav-indicators current-indicators our-dot-indicators';
    indicatorContainer.id = 'custom-page-indicators';
    
    // Style for indicators
    const style = document.createElement('style');
    style.textContent = `
        #custom-page-indicators {
            position: fixed;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 9999;
            display: flex !important;
            flex-direction: column;
            gap: 15px;
            padding: 8px;
            border-radius: 20px;
            background: rgba(0, 0, 0, 0.1);
        }
        #custom-page-indicators .section-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            border: 2px solid rgba(139, 69, 19, 0.6);
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
        #custom-page-indicators .section-indicator:hover {
            transform: scale(1.2);
            background: rgba(255, 255, 255, 0.8);
        }
        #custom-page-indicators .section-indicator.active {
            background: rgba(139, 69, 19, 0.9);
            transform: scale(1.3);
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }
        @media (max-width: 768px) {
            #custom-page-indicators {
                right: 10px;
                gap: 12px;
                padding: 6px;
            }
            #custom-page-indicators .section-indicator {
                width: 10px;
                height: 10px;
            }
        }
    `;
    document.head.appendChild(style);
    
    // Add indicator for each section
    sections.forEach(function(section, index) {
        const indicator = document.createElement('div');
        indicator.className = 'section-indicator our-dots-indicator';
        
        let sectionTitle = section.dataset.sectionName || `Section ${index + 1}`;
        sectionTitle = sectionTitle.charAt(0).toUpperCase() + sectionTitle.slice(1).replace('-', ' ');
        indicator.setAttribute('title', sectionTitle);
        
        indicator.setAttribute('data-section-index', index);
        indicator.addEventListener('click', function() {
            console.log(`Indicator ${index + 1} clicked`);
            window.moveToSection(index);
        });
        
        indicatorContainer.appendChild(indicator);
    });
    
    document.body.appendChild(indicatorContainer);
    
    // One final check to remove other indicators, but not ours
    setTimeout(function() {
        // Remove only non-custom indicators
        const fpNavs = document.querySelectorAll('#fp-nav, .fp-slidesNav');
        fpNavs.forEach(nav => nav.remove());
    }, 1000);
    
    // Return the container for later reference
    return indicatorContainer;
}

/**
 * Initialize basic animations for non-homepage pages
 */
function initializeBasicAnimations() {
    // Only run if GSAP is available
    if (typeof gsap === 'undefined') return;
    
    try {
        // Animate headings with fade in
        const headings = document.querySelectorAll('h1, h2.section-title');
        if (headings && headings.length > 0) {
            gsap.from(headings, {
                        opacity: 0,
                y: 30,
                duration: 1,
                stagger: 0.2,
                ease: 'power3.out'
            });
        }

        // Animate images with fade and scale
        const images = document.querySelectorAll('.fade-in-image, .wp-post-image');
        if (images && images.length > 0) {
            gsap.from(images, {
                opacity: 0,
                scale: 0.95,
                y: 30,
                duration: 0.8,
                stagger: 0.2,
                ease: 'power3.out'
            });
        }

        // Animate buttons with hover effect
        const buttons = document.querySelectorAll('.wp-block-button__link, .woocommerce-button, .button');
        if (buttons && buttons.length > 0) {
            buttons.forEach(function(button) {
                button.addEventListener('mouseenter', function() {
                    gsap.to(this, {
                            scale: 1.05,
                            duration: 0.3,
                            ease: 'power2.out'
                        });
                });
                
                button.addEventListener('mouseleave', function() {
                    gsap.to(this, {
                            scale: 1,
                            duration: 0.3,
                            ease: 'power2.out'
                        });
                });
            });
        }
    } catch (error) {
        console.error('Error in basic animations:', error);
    }
}

/**
 * Initialize entrance animations for homepage sections and elements
 */
function initializeEntranceAnimations() {
    // Only run if GSAP is available
    if (typeof gsap === 'undefined') return;
    
    try {
        // Animation for hero section elements
        const heroSection = document.querySelector('.hero-section');
        if (heroSection) {
            const heroTitle = heroSection.querySelector('.hero-title');
            const heroSubtitle = heroSection.querySelector('.hero-subtitle');
            // Select ALL hero buttons
            const heroButtons = heroSection.querySelectorAll('.hero-button'); 
            
            // Create timeline for hero elements
            const tl = gsap.timeline({ delay: 0.5 });
            
            if (heroTitle) {
                tl.from(heroTitle, {
            opacity: 0,
                    y: 50,
            duration: 1,
                    ease: "power3.out"
                });
            }
            
            if (heroSubtitle) {
                tl.from(heroSubtitle, {
                opacity: 0,
                    y: 30,
                duration: 1,
                    ease: "power3.out"
                }, "-=0.6");
            }
            
            // Apply animation to ALL buttons with stagger
            if (heroButtons.length > 0) { 
                tl.fromTo(heroButtons, // Target the collection
                    { // From state
                        opacity: 0,
                        y: 20
                    },
                    { // To state
                        opacity: 1, 
                        y: 0,       
                        duration: 0.8,
                        ease: "power3.out",
                        stagger: 0.15 // Add stagger
                    },
                    "-=0.4" 
                );
            }
        }
        
        // Animate featured products section
        animateSection('.featured-products-section');
        
        // Animate shop categories section
        animateShopCategories();
    } catch (error) {
        console.error('Error in entrance animations:', error);
    }
}

/**
 * Create animation for a section
 */
function animateSection(selector) {
    const section = document.querySelector(selector);
    if (!section) return;
    
    const title = section.querySelector('.section-title');
    const subtitle = section.querySelector('.section-subtitle');
    const grid = section.querySelector('.products-grid, .categories-grid');
    const items = grid ? grid.querySelectorAll('.product-card, .category-card') : [];
    
    // Create timeline with ScrollTrigger
    const tl = gsap.timeline({
        scrollTrigger: {
            trigger: section,
            start: 'top 75%',
            toggleActions: 'play none none none',
            once: true
        }
    });
    
    // Animate title
    if (title) {
        tl.from(title, {
            opacity: 0,
            y: 30,
            duration: 0.8,
            ease: "power3.out"
        });
    }
    
    // Animate subtitle
    if (subtitle) {
        tl.from(subtitle, {
            opacity: 0,
            y: 20,
            duration: 0.8,
            ease: "power3.out"
        }, "-=0.5");
    }
    
    // Animate grid
    if (grid) {
        tl.from(grid, {
            opacity: 0,
            duration: 0.6
        }, "-=0.3");
    }
    
    // Animate grid items with stagger
    if (items.length > 0) {
        tl.from(items, {
            opacity: 0,
            y: 30,
            duration: 0.8,
            stagger: 0.15,
            ease: "power3.out"
        }, "-=0.3");
    }
}

/**
 * Create specific animation for shop categories section
 */
function animateShopCategories() {
    const section = document.querySelector('.shop-categories-section');
    if (!section) return;
    
    const background = section.querySelector('.section-background');
    const overlay = section.querySelector('.overlay');
    const title = section.querySelector('.section-title');
    const subtitle = section.querySelector('.section-subtitle');
    const buttons = section.querySelectorAll('.cta-button');
    
    // Create timeline with ScrollTrigger
    const tl = gsap.timeline({
        scrollTrigger: {
            trigger: section,
            start: 'top bottom',
            end: 'center center',
            scrub: false,
            toggleActions: 'play none none none',
            once: true
        }
    });
    
    // Background reveal with scale effect
    if (background) {
        tl.fromTo(background, 
            { scale: 1.1, opacity: 0 }, 
            { scale: 1, opacity: 1, duration: 1.2, ease: "power2.out" }, 
            0
        );
    }
    
    // Fade in overlay
    if (overlay) {
        tl.fromTo(overlay, 
            { opacity: 0 }, 
            { opacity: 1, duration: 1, ease: "power2.out" }, 
            0.2
        );
    }
    
    // Fade and slide in title
    if (title) {
        tl.fromTo(title, 
            { y: 50, opacity: 0 }, 
            { y: 0, opacity: 1, duration: 0.8, ease: "back.out(1.7)" }, 
            0.4
        );
    }
    
    // Fade and slide in subtitle
    if (subtitle) {
        tl.fromTo(subtitle, 
            { y: 30, opacity: 0 }, 
            { y: 0, opacity: 1, duration: 0.8, ease: "power3.out" }, 
            0.6
        );
    }
    
    // Staggered appearance of buttons
    if (buttons.length) {
        tl.fromTo(buttons, 
            { y: 40, opacity: 0, scale: 0.9 }, 
            { 
                y: 0, 
                opacity: 1, 
                scale: 1,
                duration: 0.7, 
                stagger: 0.15, 
                ease: "back.out(1.5)"
            }, 
            0.8
        );
    }
}

/**
 * Initialize header scroll behavior - MODIFIED FOR NO HEADER ON HOMEPAGE
 */
function initializeHeaderBehavior() {
    const header = document.querySelector('.site-header');
    if (!header) return;
    
    // Don't initialize header animations on homepage
    if (document.body.classList.contains('home') || document.body.classList.contains('page-template-front-page')) {
        console.log('Homepage detected - disabling header animations completely');
        return; // Exit early - no header on homepage
    }
    
    try {
        // Regular pages still need header animations
        console.log('Regular page detected - initializing header animations');
        
        // GSAP ScrollTrigger for header state change (regular pages only)
        ScrollTrigger.create({
            trigger: "body", 
            start: "50px top",
            end: "+=1",
            toggleClass: { targets: header, className: "scrolled" },
            onEnter: () => {
                console.log('Header scrolled: Adding class');
                header.classList.add('scrolled');
            },
            onLeaveBack: () => {
                console.log('Header scrolled back: Removing class');
                header.classList.remove('scrolled');
            }
        });
    } catch (error) {
        console.error('Error in header animations:', error);
    }
}

/**
 * Initialize smooth scrolling for anchor links
 */
function initializeSmoothScroll() {
    // Only add smooth scroll if GSAP exists
    if (typeof gsap === 'undefined') return;
    
    try {
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (!href || href === '#') return;
                
                const target = document.querySelector(href);
                if (!target) return;
                
                e.preventDefault();
                
                // Use ScrollToPlugin if available
                if (typeof ScrollToPlugin !== 'undefined') {
                    gsap.to(window, {
                        duration: 0.6,
                        scrollTo: {
                            y: target,
                            offsetY: 50
                        },
                        ease: 'power2.out'
                    });
        } else {
                    // Fallback to native scroll
                    const offsetTop = target.getBoundingClientRect().top + window.pageYOffset - 50;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    } catch (error) {
        console.error('Error in smooth scroll:', error);
    }
}

/**
 * Safely create a MutationObserver instance
 * @param {Node|string} target - The DOM Node or selector string for the target element
 * @param {object} config - MutationObserver options (defaults: { childList: true, subtree: true })
 * @param {function} callback - The callback function for the observer
 * @returns {MutationObserver|null} - The observer instance or null if creation failed
 */
function createSafeObserver(target, config, callback) {
    if (!target || !callback || typeof MutationObserver === 'undefined') {
        console.warn('MutationObserver not supported or missing target/callback.');
        return null;
    }

    try {
        let element = target;
        // If target is a selector string, query for the element
        if (typeof target === 'string') {
            element = document.querySelector(target);
            if (!element) {
                console.warn(`Target element "${target}" not found for MutationObserver`);
                return null;
            }
        }

        // Ensure target is a valid DOM Node
        if (!(element instanceof Node)) {
            console.warn('MutationObserver target must be a valid DOM Node');
            return null;
        }

        const observer = new MutationObserver(callback);
        observer.observe(element, config || { childList: true, subtree: true });
        console.log('Safe MutationObserver created for:', element);
        return observer;
    } catch (error) {
        console.error('Error creating MutationObserver:', error);
        return null;
    }
}

// Make createSafeObserver globally available (if needed by other scripts, though ideally not)
// Consider scoping this better if possible or removing global exposure.
window.createSafeObserver = createSafeObserver;

// Example of initializing ScrollTrigger (if it wasn't already handled by initializePlugins)
// Ensure this runs after GSAP and ScrollTrigger are loaded.
document.addEventListener('DOMContentLoaded', function() {
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        if (!ScrollTrigger.isRegistered) { // Check if it's already registered
            try {
                gsap.registerPlugin(ScrollTrigger);
                console.log('ScrollTrigger registered via fallback check in animations.js');
            } catch (error) {
                console.error('Error registering ScrollTrigger plugin:', error);
            }
        } else {
            console.log('ScrollTrigger already registered.');
        }
    } else {
        console.warn('GSAP or ScrollTrigger not available for registration check.');
    }
});