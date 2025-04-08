/**
 * FAQ Page JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
  // FAQ Toggle
  const faqItems = document.querySelectorAll('.faq-item');
  
  faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    
    question.addEventListener('click', function() {
      const currentItem = this.parentNode;
      
      // Close all other items
      faqItems.forEach(otherItem => {
        if (otherItem !== currentItem) {
          otherItem.classList.remove('active');
        }
      });
      
      // Toggle current item
      currentItem.classList.toggle('active');
    });
  });
  
  // Category filter
  const categoryLinks = document.querySelectorAll('.faq-categories a');
  const faqSections = document.querySelectorAll('.faq-section');
  
  categoryLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Remove active class from all links
      categoryLinks.forEach(otherLink => {
        otherLink.classList.remove('active');
      });
      
      // Add active class to clicked link
      this.classList.add('active');
      
      // Hide all sections
      faqSections.forEach(section => {
        section.classList.remove('active');
      });
      
      // Show target section
      const targetId = this.getAttribute('href').substring(1); // Remove #
      const targetSection = document.getElementById(targetId);
      
      if (targetSection) {
        targetSection.classList.add('active');
        
        // Close all FAQ items when switching categories
        faqItems.forEach(item => {
          item.classList.remove('active');
        });
        
        // Smooth scroll to section on mobile
        if (window.innerWidth < 768) {
          targetSection.scrollIntoView({ behavior: 'smooth' });
        }
      }
    });
  });
  
  // FAQ Search
  const searchInput = document.getElementById('faq-search-input');
  const searchButton = document.getElementById('faq-search-btn');
  
  function performSearch() {
    const searchTerm = searchInput.value.toLowerCase().trim();
    
    if (searchTerm.length < 2) return;
    
    let foundResults = false;
    
    // Hide all items first
    faqItems.forEach(item => {
      item.style.display = 'none';
      item.classList.remove('active');
    });
    
    // Show all sections for search results
    faqSections.forEach(section => {
      section.style.display = 'block';
      
      // Find all questions in this section
      const questions = section.querySelectorAll('.faq-question h3');
      const answers = section.querySelectorAll('.faq-answer');
      
      let sectionHasResult = false;
      
      // Check questions
      questions.forEach((question, index) => {
        const questionText = question.textContent.toLowerCase();
        const answer = answers[index];
        const answerText = answer ? answer.textContent.toLowerCase() : '';
        
        if (questionText.includes(searchTerm) || answerText.includes(searchTerm)) {
          // Show this item
          question.closest('.faq-item').style.display = 'block';
          question.closest('.faq-item').classList.add('active');
          sectionHasResult = true;
          foundResults = true;
        }
      });
      
      // Hide sections with no results
      if (!sectionHasResult) {
        section.style.display = 'none';
      }
    });
    
    // Reset category links
    categoryLinks.forEach(link => {
      link.classList.remove('active');
    });
    
    // Show "no results" message if needed
    const noResultsMsg = document.querySelector('.faq-no-results');
    
    if (!foundResults) {
      if (!noResultsMsg) {
        const msg = document.createElement('div');
        msg.className = 'faq-no-results';
        msg.innerHTML = `
          <p>No results found for "${searchTerm}". Please try a different search term or browse by category.</p>
          <button id="reset-search" class="btn-reset-search">Reset Search</button>
        `;
        
        document.querySelector('.faq-content').prepend(msg);
        
        // Add event listener to reset button
        document.getElementById('reset-search').addEventListener('click', resetSearch);
      }
    } else if (noResultsMsg) {
      noResultsMsg.remove();
    }
  }
  
  function resetSearch() {
    // Clear search input
    searchInput.value = '';
    
    // Show all sections and items
    faqSections.forEach(section => {
      section.style.display = 'none';
    });
    
    faqItems.forEach(item => {
      item.style.display = 'block';
      item.classList.remove('active');
    });
    
    // Show default section
    document.getElementById('general').classList.add('active');
    
    // Update category links
    categoryLinks.forEach(link => {
      link.classList.remove('active');
      
      if (link.getAttribute('href') === '#general') {
        link.classList.add('active');
      }
    });
    
    // Remove no results message
    const noResultsMsg = document.querySelector('.faq-no-results');
    if (noResultsMsg) {
      noResultsMsg.remove();
    }
  }
  
  if (searchButton) {
    searchButton.addEventListener('click', performSearch);
  }
  
  if (searchInput) {
    searchInput.addEventListener('keyup', function(e) {
      if (e.key === 'Enter') {
        performSearch();
      }
      
      // Reset search if input is cleared
      if (this.value.trim() === '') {
        resetSearch();
      }
    });
  }
}); 