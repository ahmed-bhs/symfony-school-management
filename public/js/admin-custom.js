/**
 * Script personnalisé pour améliorer l'UX de l'administration
 */

document.addEventListener('DOMContentLoaded', function() {
    // Animation des cartes au chargement
    animateCards();

    // Tooltips Bootstrap
    initTooltips();

    // Confirmation de suppression
    confirmDelete();

    // Recherche en temps réel
    enhanceSearch();

    // Statistiques animées
    animateNumbers();

    // Mise à jour de l'heure en temps réel
    updateClock();
});

/**
 * Animation des cartes au chargement de la page
 */
function animateCards() {
    const cards = document.querySelectorAll('.card, .stats-card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('fade-in');
        }, index * 100);
    });
}

/**
 * Initialisation des tooltips Bootstrap
 */
function initTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

/**
 * Confirmation avant suppression
 */
function confirmDelete() {
    const deleteButtons = document.querySelectorAll('a[href*="delete"], button[name*="delete"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                e.preventDefault();
                return false;
            }
        });
    });
}

/**
 * Amélioration de la recherche avec feedback visuel
 */
function enhanceSearch() {
    const searchInputs = document.querySelectorAll('input[type="search"]');
    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value.length > 0) {
                this.classList.add('border-primary');
            } else {
                this.classList.remove('border-primary');
            }
        });
    });
}

/**
 * Animation des nombres (compteur)
 */
function animateNumbers() {
    const numbers = document.querySelectorAll('.h5.mb-0, .badge-pill');

    numbers.forEach(element => {
        const text = element.textContent.trim();
        const match = text.match(/^(\d+)/);

        if (match) {
            const finalNumber = parseInt(match[1]);
            if (finalNumber > 0 && finalNumber < 10000) {
                animateValue(element, 0, finalNumber, 1000);
            }
        }
    });
}

/**
 * Anime un nombre de 'start' à 'end' en 'duration' ms
 */
function animateValue(element, start, end, duration) {
    const range = end - start;
    const increment = range / (duration / 16); // 60 FPS
    let current = start;
    const originalText = element.textContent;
    const suffix = originalText.replace(/^\d+/, '');

    const timer = setInterval(() => {
        current += increment;
        if (current >= end) {
            element.textContent = end + suffix;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current) + suffix;
        }
    }, 16);
}

/**
 * Met à jour l'horloge en temps réel
 */
function updateClock() {
    const clockElements = document.querySelectorAll('.text-muted i.fa-calendar-alt');

    if (clockElements.length > 0) {
        setInterval(() => {
            const now = new Date();
            const dateStr = now.toLocaleDateString('fr-FR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            clockElements.forEach(icon => {
                const parent = icon.parentElement;
                if (parent) {
                    parent.innerHTML = `<i class="far fa-calendar-alt"></i> ${dateStr}`;
                }
            });
        }, 60000); // Mise à jour chaque minute
    }
}

/**
 * Gestion des progress bars animées
 */
function animateProgressBars() {
    const progressBars = document.querySelectorAll('.progress-bar');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const bar = entry.target;
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
                observer.unobserve(bar);
            }
        });
    });

    progressBars.forEach(bar => observer.observe(bar));
}

// Lancer l'animation des progress bars
animateProgressBars();

/**
 * Amélioration de l'accessibilité du clavier
 */
document.addEventListener('keydown', function(e) {
    // Échap pour fermer les modales
    if (e.key === 'Escape') {
        const modals = document.querySelectorAll('.modal.show');
        modals.forEach(modal => {
            const bsModal = bootstrap.Modal.getInstance(modal);
            if (bsModal) bsModal.hide();
        });
    }

    // Ctrl+K pour focus sur la recherche
    if (e.ctrlKey && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.querySelector('input[type="search"]');
        if (searchInput) searchInput.focus();
    }
});

/**
 * Auto-save pour les formulaires (draft)
 */
function enableAutoSave() {
    const forms = document.querySelectorAll('form[name*="edit"], form[name*="new"]');

    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');

        inputs.forEach(input => {
            input.addEventListener('change', function() {
                const formData = new FormData(form);
                const key = `draft_${form.name || 'form'}`;

                // Sauvegarder dans localStorage
                localStorage.setItem(key, JSON.stringify(Object.fromEntries(formData)));

                // Afficher un indicateur de sauvegarde
                showSaveIndicator();
            });
        });
    });
}

/**
 * Affiche un indicateur de sauvegarde automatique
 */
function showSaveIndicator() {
    let indicator = document.querySelector('.auto-save-indicator');

    if (!indicator) {
        indicator = document.createElement('div');
        indicator.className = 'auto-save-indicator alert alert-success position-fixed';
        indicator.style.cssText = 'bottom: 20px; right: 20px; z-index: 9999; opacity: 0; transition: opacity 0.3s;';
        indicator.innerHTML = '<i class="fas fa-check-circle"></i> Sauvegarde automatique';
        document.body.appendChild(indicator);
    }

    indicator.style.opacity = '1';

    setTimeout(() => {
        indicator.style.opacity = '0';
    }, 2000);
}

/**
 * Amélioration du tri des tableaux
 */
function enhanceTableSorting() {
    const tables = document.querySelectorAll('.table');

    tables.forEach(table => {
        const headers = table.querySelectorAll('th[data-sort]');

        headers.forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', function() {
                sortTable(table, this);
            });
        });
    });
}

/**
 * Tri d'un tableau
 */
function sortTable(table, header) {
    const columnIndex = Array.from(header.parentNode.children).indexOf(header);
    const rows = Array.from(table.querySelectorAll('tbody tr'));
    const isAscending = header.classList.contains('sort-asc');

    rows.sort((a, b) => {
        const aValue = a.children[columnIndex].textContent.trim();
        const bValue = b.children[columnIndex].textContent.trim();

        if (isAscending) {
            return bValue.localeCompare(aValue);
        } else {
            return aValue.localeCompare(bValue);
        }
    });

    const tbody = table.querySelector('tbody');
    rows.forEach(row => tbody.appendChild(row));

    // Toggle class
    header.classList.toggle('sort-asc', !isAscending);
    header.classList.toggle('sort-desc', isAscending);
}

// Activer l'auto-save
enableAutoSave();

// Améliorer le tri des tableaux
enhanceTableSorting();

console.log('🎓 Administration scolaire - Scripts chargés avec succès');
