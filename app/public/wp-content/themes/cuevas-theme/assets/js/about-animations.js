/**
 * About page specific animations for Cuevas Western Wear theme
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize about page specific animations
    initializeAboutPageAnimations();
});

/**
 * Initialize animations specific to the about page
 */
function initializeAboutPageAnimations() {
    // Timeline animations
    const timelineItems = document.querySelectorAll('.timeline-item');
    timelineItems.forEach((item, index) => {
        gsap.from(item, {
            x: index % 2 === 0 ? -100 : 100,
            opacity: 0,
            duration: 1,
            scrollTrigger: {
                trigger: item,
                start: 'top 80%',
                end: 'bottom 20%',
                toggleActions: 'play none none reverse'
            }
        });
    });

    // Craftsmanship section animations
    const craftItems = document.querySelectorAll('.craft-item');
    craftItems.forEach((item, index) => {
        const image = item.querySelector('img');
        const content = item.querySelector('h4, p');

        // Image animation
        gsap.from(image, {
            scale: 0.8,
            opacity: 0,
            duration: 1,
            scrollTrigger: {
                trigger: item,
                start: 'top 80%',
                toggleActions: 'play none none reverse'
            }
        });

        // Content animation
        gsap.from(content, {
            y: 50,
            opacity: 0,
            duration: 1,
            delay: 0.3,
            scrollTrigger: {
                trigger: item,
                start: 'top 80%',
                toggleActions: 'play none none reverse'
            }
        });
    });

    // Trust badges animation
    const trustBadges = document.querySelectorAll('.trust-badge');
    gsap.from(trustBadges, {
        y: 50,
        opacity: 0,
        duration: 0.8,
        stagger: 0.2,
        scrollTrigger: {
            trigger: '.trust-badges',
            start: 'top 80%',
            toggleActions: 'play none none reverse'
        }
    });

    // Brand story section parallax effect
    const brandSection = document.querySelector('.brand-section');
    if (brandSection && !cuevasAnimConfig.isMobile) {
        gsap.to(brandSection, {
            backgroundPositionY: '50%',
            ease: 'none',
            scrollTrigger: {
                trigger: brandSection,
                start: 'top bottom',
                end: 'bottom top',
                scrub: true
            }
        });
    }

    // Initialize text animations for brand story
    const brandStoryText = document.querySelector('.brand-story p');
    if (brandStoryText) {
        createTextReveal(brandStoryText, {
            y: 30,
            opacity: 0,
            duration: 1.2,
            stagger: 0.05
        });
    }

    // Animate trust badge icons
    const trustIcons = document.querySelectorAll('.trust-icon');
    trustIcons.forEach(icon => {
        // Initial scale animation
        gsap.from(icon, {
            scale: 0,
            rotation: -180,
            duration: 1,
            scrollTrigger: {
                trigger: icon,
                start: 'top 80%',
                toggleActions: 'play none none reverse'
            }
        });

        // Hover animation
        icon.addEventListener('mouseenter', () => {
            gsap.to(icon, {
                scale: 1.2,
                rotation: 360,
                duration: 0.5,
                ease: 'back.out(1.7)'
            });
        });

        icon.addEventListener('mouseleave', () => {
            gsap.to(icon, {
                scale: 1,
                rotation: 0,
                duration: 0.5,
                ease: 'back.out(1.7)'
            });
        });
    });
}

/**
 * Utility function to create timeline connector animations
 */
// Removed animateTimelineConnectors function as it was unused 