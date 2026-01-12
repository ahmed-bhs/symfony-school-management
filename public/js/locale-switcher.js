/**
 * Gestion du changement de langue et du RTL
 */

document.addEventListener('DOMContentLoaded', function() {
    // Détecter la langue actuelle
    const currentLocale = document.documentElement.lang || 'fr';

    // Appliquer le RTL pour l'arabe
    if (currentLocale === 'ar') {
        document.documentElement.setAttribute('dir', 'rtl');
        document.documentElement.setAttribute('lang', 'ar');

        // Charger le CSS RTL
        const rtlLink = document.createElement('link');
        rtlLink.rel = 'stylesheet';
        rtlLink.href = '/css/rtl.css';
        document.head.appendChild(rtlLink);
    } else {
        document.documentElement.setAttribute('dir', 'ltr');
        document.documentElement.setAttribute('lang', currentLocale);
    }

    // Ajouter des listeners sur les liens de changement de langue
    const languageSwitchers = document.querySelectorAll('[data-locale]');
    languageSwitchers.forEach(switcher => {
        switcher.addEventListener('click', function(e) {
            e.preventDefault();
            const locale = this.getAttribute('data-locale');

            // Créer un formulaire pour changer la locale
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = `/change-language/${locale}`;
            document.body.appendChild(form);
            form.submit();
        });
    });
});

/**
 * Créer un sélecteur de langue personnalisé
 */
function createLanguageSwitcher() {
    const currentLocale = document.documentElement.lang || 'fr';

    const languages = {
        'fr': { flag: '🇫🇷', name: 'Français' },
        'en': { flag: '🇬🇧', name: 'English' },
        'ar': { flag: '🇸🇦', name: 'العربية' }
    };

    const container = document.createElement('div');
    container.className = 'language-switcher dropdown';
    container.style.cssText = 'position: fixed; top: 70px; right: 20px; z-index: 1000;';

    const currentLang = languages[currentLocale];

    const button = document.createElement('button');
    button.className = 'btn btn-sm btn-light dropdown-toggle';
    button.type = 'button';
    button.id = 'languageDropdown';
    button.setAttribute('data-bs-toggle', 'dropdown');
    button.setAttribute('aria-expanded', 'false');
    button.innerHTML = `${currentLang.flag} ${currentLang.name}`;

    const menu = document.createElement('ul');
    menu.className = 'dropdown-menu';
    menu.setAttribute('aria-labelledby', 'languageDropdown');

    Object.entries(languages).forEach(([code, lang]) => {
        const item = document.createElement('li');
        const link = document.createElement('a');
        link.className = 'dropdown-item';
        link.href = `/change-language/${code}`;
        link.setAttribute('data-locale', code);
        link.innerHTML = `${lang.flag} ${lang.name}`;

        if (code === currentLocale) {
            link.classList.add('active');
        }

        item.appendChild(link);
        menu.appendChild(item);
    });

    container.appendChild(button);
    container.appendChild(menu);

    // Insérer le sélecteur dans le DOM
    document.body.appendChild(container);
}

// Créer le sélecteur de langue
// createLanguageSwitcher();
