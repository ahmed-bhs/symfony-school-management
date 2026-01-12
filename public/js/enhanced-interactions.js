/**
 * Enhanced Interactions & UX Improvements
 * Smooth, professional, intuitive
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all enhancements
    initSmoothScrolling();
    initProgressBars();
    initCountUpAnimations();
    initTooltips();
    initTableEnhancements();
    initFormEnhancements();
    initSearchHighlight();
    initKeyboardShortcuts();
});

/**
 * Smooth scrolling for anchor links
 */
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && document.querySelector(href)) {
                e.preventDefault();
                document.querySelector(href).scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

/**
 * Animate progress bars when they come into view
 */
function initProgressBars() {
    const progressBars = document.querySelectorAll('.progress-bar-modern');

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
    }, { threshold: 0.5 });

    progressBars.forEach(bar => observer.observe(bar));
}

/**
 * Count up animation for numbers
 */
function initCountUpAnimations() {
    const statValues = document.querySelectorAll('.stat-card-value');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                const text = element.textContent.trim();
                const number = parseInt(text.replace(/[^\d]/g, ''));

                if (!isNaN(number) && number > 0 && number < 10000) {
                    animateCount(element, 0, number, 1500);
                }

                observer.unobserve(element);
            }
        });
    }, { threshold: 0.5 });

    statValues.forEach(stat => observer.observe(stat));
}

function animateCount(element, start, end, duration) {
    const originalText = element.textContent;
    const suffix = originalText.replace(/^\d+/, '');
    const range = end - start;
    const increment = range / (duration / 16);
    let current = start;

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
 * Enhanced tooltips
 */
function initTooltips() {
    const elements = document.querySelectorAll('[title]');

    elements.forEach(el => {
        const title = el.getAttribute('title');
        if (!title) return;

        el.removeAttribute('title');
        el.setAttribute('data-tooltip', title);

        el.addEventListener('mouseenter', showTooltip);
        el.addEventListener('mouseleave', hideTooltip);
    });
}

function showTooltip(e) {
    const text = e.target.getAttribute('data-tooltip');
    if (!text) return;

    const tooltip = document.createElement('div');
    tooltip.className = 'custom-tooltip';
    tooltip.textContent = text;
    tooltip.style.cssText = `
        position: absolute;
        background: #1f2937;
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        z-index: 9999;
        pointer-events: none;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        animation: tooltipFadeIn 0.2s ease-out;
    `;

    document.body.appendChild(tooltip);

    const rect = e.target.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.bottom + 8 + 'px';

    e.target._tooltip = tooltip;
}

function hideTooltip(e) {
    if (e.target._tooltip) {
        e.target._tooltip.remove();
        delete e.target._tooltip;
    }
}

/**
 * Table enhancements
 */
function initTableEnhancements() {
    const tables = document.querySelectorAll('.table-modern');

    tables.forEach(table => {
        // Row click to select
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.style.cursor = 'pointer';

            row.addEventListener('click', function(e) {
                if (e.target.tagName !== 'A' && e.target.tagName !== 'BUTTON') {
                    const link = this.querySelector('a');
                    if (link) {
                        window.location.href = link.href;
                    }
                }
            });
        });

        // Sortable headers
        const headers = table.querySelectorAll('thead th');
        headers.forEach((header, index) => {
            if (header.textContent.trim()) {
                header.style.cursor = 'pointer';
                header.style.userSelect = 'none';

                header.addEventListener('click', function() {
                    sortTable(table, index);
                });
            }
        });
    });
}

function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const header = table.querySelectorAll('thead th')[columnIndex];

    const isAscending = header.classList.contains('sort-asc');

    rows.sort((a, b) => {
        const aText = a.children[columnIndex]?.textContent.trim() || '';
        const bText = b.children[columnIndex]?.textContent.trim() || '';

        const aNum = parseFloat(aText);
        const bNum = parseFloat(bText);

        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAscending ? bNum - aNum : aNum - bNum;
        }

        return isAscending
            ? bText.localeCompare(aText)
            : aText.localeCompare(bText);
    });

    rows.forEach(row => tbody.appendChild(row));

    // Update sort indicators
    table.querySelectorAll('thead th').forEach(th => {
        th.classList.remove('sort-asc', 'sort-desc');
    });

    header.classList.add(isAscending ? 'sort-desc' : 'sort-asc');
}

/**
 * Form enhancements
 */
function initFormEnhancements() {
    const inputs = document.querySelectorAll('.form-control-modern, input[type="text"], input[type="email"], input[type="password"], textarea');

    inputs.forEach(input => {
        // Floating labels effect
        input.addEventListener('focus', function() {
            this.parentElement?.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement?.classList.remove('focused');
            }
        });

        // Auto-save draft to localStorage
        if (input.name) {
            const savedValue = localStorage.getItem('draft_' + input.name);
            if (savedValue && !input.value) {
                input.value = savedValue;
            }

            input.addEventListener('input', debounce(function() {
                localStorage.setItem('draft_' + input.name, this.value);
            }, 500));
        }
    });
}

/**
 * Search highlight
 */
function initSearchHighlight() {
    const searchInputs = document.querySelectorAll('input[type="search"]');

    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            const query = this.value.toLowerCase();

            if (query.length < 2) {
                clearHighlights();
                return;
            }

            const content = document.querySelector('.table-modern tbody');
            if (!content) return;

            clearHighlights();

            const walker = document.createTreeWalker(
                content,
                NodeFilter.SHOW_TEXT,
                null,
                false
            );

            const nodesToHighlight = [];
            let node;

            while (node = walker.nextNode()) {
                if (node.textContent.toLowerCase().includes(query)) {
                    nodesToHighlight.push(node);
                }
            }

            nodesToHighlight.forEach(node => {
                const parent = node.parentNode;
                const text = node.textContent;
                const regex = new RegExp(`(${escapeRegex(query)})`, 'gi');
                const html = text.replace(regex, '<mark class="search-highlight">$1</mark>');

                const span = document.createElement('span');
                span.innerHTML = html;
                parent.replaceChild(span, node);
            });
        });
    });
}

function clearHighlights() {
    document.querySelectorAll('.search-highlight').forEach(mark => {
        const parent = mark.parentNode;
        parent.replaceChild(document.createTextNode(mark.textContent), mark);
        parent.normalize();
    });
}

function escapeRegex(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

/**
 * Keyboard shortcuts
 */
function initKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K: Focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const search = document.querySelector('input[type="search"]');
            if (search) {
                search.focus();
                search.select();
            }
        }

        // Escape: Clear search
        if (e.key === 'Escape') {
            const search = document.querySelector('input[type="search"]');
            if (search && search.value) {
                search.value = '';
                search.dispatchEvent(new Event('input'));
            }
        }

        // Ctrl/Cmd + S: Prevent default, show save indicator
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            showNotification('Sauvegarde automatique active', 'success');
        }
    });
}

/**
 * Utility: Debounce function
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func.apply(this, args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Show notification
 */
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: ${type === 'success' ? '#10b981' : '#3b82f6'};
        color: white;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        z-index: 10000;
        animation: slideInRight 0.3s ease-out;
        font-size: 0.875rem;
        font-weight: 500;
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

/**
 * Add loading state to buttons
 */
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn && !submitBtn.classList.contains('loading')) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            const originalText = submitBtn.textContent;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + originalText;

            // Re-enable after 5 seconds as fallback
            setTimeout(() => {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }, 5000);
        }
    });
});

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    @keyframes tooltipFadeIn {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes slideOutRight {
        from { opacity: 1; transform: translateX(0); }
        to { opacity: 0; transform: translateX(20px); }
    }

    .search-highlight {
        background: #fef3c7;
        color: #92400e;
        padding: 0.125rem 0.25rem;
        border-radius: 0.25rem;
        font-weight: 600;
    }

    .focused {
        transform: translateY(-2px);
        transition: transform 0.2s;
    }
`;
document.head.appendChild(style);

console.log('Enhanced interactions initialized');
