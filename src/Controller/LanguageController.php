<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class LanguageController extends AbstractController
{
    #[Route('/change-language/{locale}', name: 'change_language')]
    public function changeLanguage(string $locale, Request $request): RedirectResponse
    {
        // Valider la locale
        $allowedLocales = ['fr', 'en', 'ar'];

        if (!in_array($locale, $allowedLocales)) {
            $locale = 'fr'; // Par défaut
        }

        // Stocker la locale dans la session
        $request->getSession()->set('_locale', $locale);

        // Rediriger vers la page précédente ou vers l'admin
        $referer = $request->headers->get('referer');
        if ($referer) {
            return $this->redirect($referer);
        }

        return $this->redirectToRoute('admin');
    }
}
