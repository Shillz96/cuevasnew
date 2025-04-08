/**
 * Shop Page JavaScript
 * Handles shop page specific functionality
 */

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Filter toggle functionality
    const filterToggle = document.querySelector('.filter-toggle');
    const filterSidebar = document.querySelector('.filter-sidebar');
    
    if (filterToggle && filterSidebar) {
        filterToggle.addEventListener('click', function() {
            filterSidebar.classList.toggle('active');
            
            // Accessibility
            const isExpanded = filterSidebar.classList.contains('active');
            filterToggle.setAttribute('aria-expanded', isExpanded);
            
            // Update button text
            if (isExpanded) {
                filterToggle.innerHTML = '<i class="fas fa-times"></i> Close Filters';
            } else {
                filterToggle.innerHTML = '<i class="fas fa-sliders-h"></i> Filter';
            }
        });
        
        // Initialize attributes
        filterToggle.setAttribute('aria-controls', 'filter-sidebar');
        filterToggle.setAttribute('aria-expanded', 'false');
        filterSidebar.id = 'filter-sidebar';
    }
    
    // Quantity buttons functionality for cart page
    const setupQuantityButtons = () => {
        const quantityInputs = document.querySelectorAll('.quantity .qty');
        
        quantityInputs.forEach(input => {
            // Don't add buttons if they already exist
            if (input.parentNode.querySelector('.quantity-button')) {
                return;
            }
            
            // Create wrapper if needed
            let wrapper = input.parentNode;
            if (!wrapper.classList.contains('quantity-wrapper')) {
                wrapper = document.createElement('div');
                wrapper.className = 'quantity-wrapper';
                input.parentNode.insertBefore(wrapper, input);
                wrapper.appendChild(input);
            }
            
            // Create minus button
            const minusButton = document.createElement('button');
            minusButton.type = 'button';
            minusButton.className = 'quantity-button minus';
            minusButton.innerHTML = '-';
            minusButton.setAttribute('aria-label', 'Decrease quantity');
            
            // Create plus button
            const plusButton = document.createElement('button');
            plusButton.type = 'button';
            plusButton.className = 'quantity-button plus';
            plusButton.innerHTML = '+';
            plusButton.setAttribute('aria-label', 'Increase quantity');
            
            // Insert buttons
            wrapper.insertBefore(minusButton, input);
            wrapper.appendChild(plusButton);
            
            // Setup event handlers
            minusButton.addEventListener('click', () => {
                const currentValue = parseInt(input.value);
                if (currentValue > parseInt(input.min || 1)) {
                    input.value = currentValue - 1;
                    // Trigger change event to update cart
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
            
            plusButton.addEventListener('click', () => {
                const currentValue = parseInt(input.value);
                const maxValue = parseInt(input.max);
                if (!maxValue || currentValue < maxValue) {
                    input.value = currentValue + 1;
                    // Trigger change event to update cart
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
        });
    };
    
    // Run quantity setup
    setupQuantityButtons();
    
    // Run again when cart is updated (for AJAX cart updates)
    document.body.addEventListener('updated_cart_totals', setupQuantityButtons);
}); 