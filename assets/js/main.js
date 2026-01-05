// ========================================
// BUYMATCH - Main JavaScript
// Simple Vanilla JS for OOP Focus
// ========================================

// === DOM READY ===
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

// === INITIALIZE APP ===
function initializeApp() {
    // Initialize all components
    initModals();
    initForms();
    initAlerts();
    console.log('BuyMatch App Initialized');
}

// === MODAL FUNCTIONALITY ===
function initModals() {
    // Open modal
    const modalTriggers = document.querySelectorAll('[data-modal-target]');
    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const modalId = this.getAttribute('data-modal-target');
            openModal(modalId);
        });
    });

    // Close modal
    const modalCloses = document.querySelectorAll('.modal-close, [data-modal-close]');
    modalCloses.forEach(close => {
        close.addEventListener('click', function() {
            const modal = this.closest('.modal-overlay');
            closeModal(modal);
        });
    });

    // Close modal on overlay click
    const modalOverlays = document.querySelectorAll('.modal-overlay');
    modalOverlays.forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this);
            }
        });
    });
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modal) {
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

// === FORM VALIDATION ===
function initForms() {
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });
}

function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            showFieldError(field, 'Ce champ est requis');
            isValid = false;
        } else {
            clearFieldError(field);
        }
    });
    
    // Email validation
    const emailFields = form.querySelectorAll('input[type="email"]');
    emailFields.forEach(field => {
        if (field.value && !isValidEmail(field.value)) {
            showFieldError(field, 'Email invalide');
            isValid = false;
        }
    });
    
    return isValid;
}

function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function showFieldError(field, message) {
    clearFieldError(field);
    field.classList.add('error');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.style.color = '#ef4444';
    errorDiv.style.fontSize = '0.875rem';
    errorDiv.style.marginTop = '0.25rem';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('error');
    const error = field.parentNode.querySelector('.field-error');
    if (error) {
        error.remove();
    }
}

// === ALERT FUNCTIONALITY ===
function initAlerts() {
    const alerts = document.querySelectorAll('.alert[data-auto-close]');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 5000);
    });
}

function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    
    const container = document.querySelector('.container') || document.body;
    container.insertBefore(alertDiv, container.firstChild);
    
    setTimeout(() => {
        alertDiv.style.display = 'none';
    }, 5000);
}

// === SEAT SELECTION (for ticket buying) ===
function initSeatSelection() {
    const seats = document.querySelectorAll('.seat:not(.occupied)');
    const maxSeats = 4;
    let selectedSeats = [];
    
    seats.forEach(seat => {
        seat.addEventListener('click', function() {
            if (this.classList.contains('selected')) {
                // Deselect
                this.classList.remove('selected');
                selectedSeats = selectedSeats.filter(s => s !== this.dataset.seatId);
            } else {
                // Select
                if (selectedSeats.length < maxSeats) {
                    this.classList.add('selected');
                    selectedSeats.push(this.dataset.seatId);
                } else {
                    showAlert(`Vous ne pouvez sélectionner que ${maxSeats} places maximum`, 'warning');
                }
            }
            updateSelectedSeatsDisplay();
        });
    });
}

function updateSelectedSeatsDisplay() {
    const selectedSeats = document.querySelectorAll('.seat.selected');
    const displayElement = document.getElementById('selected-seats-count');
    if (displayElement) {
        displayElement.textContent = selectedSeats.length;
    }
}

// === FILTER FUNCTIONALITY ===
function initFilters() {
    const filterInputs = document.querySelectorAll('.filter-bar input, .filter-bar select');
    
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            applyFilters();
        });
    });
}

function applyFilters() {
    // This would typically make an AJAX call to your PHP backend
    // For now, it's a placeholder
    console.log('Applying filters...');
}

// === CONFIRM DIALOG ===
function confirmAction(message) {
    return confirm(message);
}

// === LOADING SPINNER ===
function showLoading() {
    const loader = document.createElement('div');
    loader.id = 'loading-overlay';
    loader.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    `;
    loader.innerHTML = '<div style="color: white; font-size: 1.5rem;">Chargement...</div>';
    document.body.appendChild(loader);
}

function hideLoading() {
    const loader = document.getElementById('loading-overlay');
    if (loader) {
        loader.remove();
    }
}

// === FORMAT DATE ===
function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return date.toLocaleDateString('fr-FR', options);
}

// === FORMAT PRICE ===
function formatPrice(price) {
    return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'MAD' }).format(price);
}

// === EXPORT FUNCTIONS ===
window.BuyMatch = {
    openModal,
    closeModal,
    showAlert,
    confirmAction,
    showLoading,
    hideLoading,
    formatDate,
    formatPrice,
    initSeatSelection,
    initFilters
};
function bindLogoPreview(inputId, imgId, errorId) {
    const input = document.getElementById(inputId);
    const img = document.getElementById(imgId);
    const err = document.getElementById(errorId);

    function isLikelyUrl(value) {
      try {
        const u = new URL(value);
        return u.protocol === "http:" || u.protocol === "https:";
      } catch (e) {
        return false;
      }
    }

    input.addEventListener("input", () => {
      const url = input.value.trim();

      // reset
      img.style.display = "none";
      err.style.display = "none";
      img.removeAttribute("src");

      if (!url) return;

      if (!isLikelyUrl(url)) {
        err.style.display = "block";
        return;
      }

      // set preview
      img.src = url;
      img.style.display = "block";

      // if image fails to load (404, not an image, blocked, etc.)
      img.onerror = () => {
        img.style.display = "none";
        err.style.display = "block";
      };

      img.onload = () => {
        err.style.display = "none";
      };
    });
  }

  bindLogoPreview("team1_logo_url", "team1_logo_preview", "team1_logo_error");
  bindLogoPreview("team2_logo_url", "team2_logo_preview", "team2_logo_error");