<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AsEventListener(event: KernelEvents::REQUEST, priority: 100)]
class LocaleListener
{
    private const ALLOWED_LOCALES = ['fr', 'en', 'ar'];
    private const DEFAULT_LOCALE = 'fr';

    public function __construct(
        private TranslatorInterface $translator
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        // Vérifier si le paramètre _locale est dans l'URL (utilisé par EasyAdmin)
        if ($locale = $request->query->get('_locale')) {
            // Valider la locale
            if (in_array($locale, self::ALLOWED_LOCALES)) {
                // Stocker dans la session
                $request->getSession()->set('_locale', $locale);
                // Définir la locale de la requête
                $request->setLocale($locale);
                // Définir la locale du translator
                $this->translator->setLocale($locale);
                return;
            }
        }

        // Sinon, récupérer la locale depuis la session
        if ($locale = $request->getSession()->get('_locale')) {
            $request->setLocale($locale);
            $this->translator->setLocale($locale);
        } else {
            // Définir la locale par défaut si aucune n'est trouvée
            $request->setLocale(self::DEFAULT_LOCALE);
            $request->getSession()->set('_locale', self::DEFAULT_LOCALE);
            $this->translator->setLocale(self::DEFAULT_LOCALE);
        }
    }
}
