/**
 * Product Page JavaScript
 * 
 * Handle sidebar toggle, mobile menu, and other product page interactions.
 */

(function() {
    'use strict';
    
    // DOM elements
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.shop-sidebar');
    const sidebarOverlay = document.querySelector('.sidebar-overlay');
    const sidebarClose = document.querySelector('.sidebar-close');
    const menuToggle = document.querySelector('.menu-toggle');
    const mainNavigation = document.querySelector('.main-navigation');
    const header = document.querySelector('.compact-header');
    
    // Price slider elements
    const minHandle = document.querySelector('.price-handle.min');
    const maxHandle = document.querySelector('.price-handle.max');
    const priceRange = document.querySelector('.price-range');
    
    // Initialize the page
    function init() {
        setupEventListeners();
        setupScrollEffects();
        
        if (minHandle && maxHandle && priceRange) {
            setupPriceSlider();
        }
    }
    
    // Set up event listeners
    function setupEventListeners() {
        // Sidebar toggle on mobile
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }
        
        // Sidebar overlay click to close
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebar);
        }
        
        // Sidebar close button
        if (sidebarClose) {
            sidebarClose.addEventListener('click', closeSidebar);
        }
        
        // Mobile menu toggle
        if (menuToggle) {
            menuToggle.addEventListener('click', toggleMobileMenu);
        }
        
        // Handle window resize
        window.addEventListener('resize', handleResize);
    }
    
    // Toggle sidebar visibility
    function toggleSidebar() {
        sidebar.classList.toggle('active');
        sidebarToggle.classList.toggle('active');
        sidebarOverlay.classList.toggle('active');
        document.body.classList.toggle('sidebar-open');
    }
    
    // Close sidebar
    function closeSidebar() {
        sidebar.classList.remove('active');
        sidebarToggle.classList.remove('active');
        sidebarOverlay.classList.remove('active');
        document.body.classList.remove('sidebar-open');
    }
    
    // Toggle mobile menu
    function toggleMobileMenu() {
        menuToggle.classList.toggle('active');
        mainNavigation.classList.toggle('active');
        document.body.classList.toggle('menu-open');
    }
    
    // Close mobile menu
    function closeMobileMenu() {
        menuToggle.classList.remove('active');
        mainNavigation.classList.remove('active');
        document.body.classList.remove('menu-open');
    }
    
    // Handle window resize events
    function handleResize() {
        const windowWidth = window.innerWidth;
        
        // Close mobile menu on larger screens
        if (windowWidth > 768 && mainNavigation.classList.contains('active')) {
            closeMobileMenu();
        }
        
        // Reset sidebar on desktop
        if (windowWidth > 768 && sidebar && sidebar.classList.contains('active')) {
            closeSidebar();
        }
    }
    
    // Setup scroll effects
    function setupScrollEffects() {
        let lastScrollTop = 0;
        
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Header shrink effect
            if (header) {
                if (scrollTop > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            }
            
            lastScrollTop = scrollTop;
        });
    }
    
    // Setup price range slider
    function setupPriceSlider() {
        function updatePriceRange() {
            const minPos = parseFloat(minHandle.style.left || '0');
            const maxPos = parseFloat(maxHandle.style.left || '30');
            
            priceRange.style.left = `${minPos}%`;
            priceRange.style.right = `${100 - maxPos}%`;
            
            // Update price values display if they exist
            const minPriceDisplay = document.querySelector('.min-price');
            const maxPriceDisplay = document.querySelector('.max-price');
            
            if (minPriceDisplay && maxPriceDisplay) {
                const minPrice = Math.round((minPos / 100) * 500);
                const maxPrice = Math.round((maxPos / 100) * 500);
                
                minPriceDisplay.textContent = `$${minPrice}`;
                maxPriceDisplay.textContent = `$${maxPrice}`;
            }
        }
        
        // Handle min price handle drag
        minHandle.addEventListener('mousedown', function(e) {
            e.preventDefault();
            
            function onMouseMove(e) {
                const sliderRect = document.querySelector('.price-slider').getBoundingClientRect();
                let pos = (e.clientX - sliderRect.left) / sliderRect.width * 100;
                
                // Constrain position
                pos = Math.max(0, Math.min(pos, parseFloat(maxHandle.style.left || '30') - 5));
                
                minHandle.style.left = `${pos}%`;
                updatePriceRange();
            }
            
            function onMouseUp() {
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
            }
            
            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        });
        
        // Handle max price handle drag
        maxHandle.addEventListener('mousedown', function(e) {
            e.preventDefault();
            
            function onMouseMove(e) {
                const sliderRect = document.querySelector('.price-slider').getBoundingClientRect();
                let pos = (e.clientX - sliderRect.left) / sliderRect.width * 100;
                
                // Constrain position
                pos = Math.min(100, Math.max(pos, parseFloat(minHandle.style.left || '0') + 5));
                
                maxHandle.style.left = `${pos}%`;
                updatePriceRange();
            }
            
            function onMouseUp() {
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
            }
            
            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        });
        
        // Initialize price range
        updatePriceRange();
    }
    
    // Initialize when DOM is fully loaded
    document.addEventListener('DOMContentLoaded', init);
})();

// GSAP Animation for Product Gallery from product-page.md
document.addEventListener('DOMContentLoaded', function() {
  if (document.querySelector('.woocommerce-product-gallery__image')) {
    gsap.from('.woocommerce-product-gallery__image', {
      opacity: 0,
      scale: 0.9,
      duration: 1,
      ease: 'power2.out',
    });
  }
}); 