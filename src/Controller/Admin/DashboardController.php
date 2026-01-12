<?php

namespace App\Controller\Admin;

use App\Entity\Absence;
use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Entity\Evaluation;
use App\Entity\Exercice;
use App\Entity\Note;
use App\Entity\Prof;
use App\Entity\Seance;
use App\Service\DashboardStatsService;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private DashboardStatsService $statsService,
        private TranslatorInterface $translator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $stats = $this->statsService->getAllStats();

        return $this->render('admin/dashboard_professional.html.twig', [
            'stats' => $stats,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle($this->translator->trans('app.name', [], 'messages'))
            ->setFaviconPath('favicon.ico')
            ->setLocales(['fr' => 'Français', 'en' => 'English', 'ar' => 'العربية']);
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addCssFile('css/professional-theme.css')
            ->addCssFile('css/enhanced-theme.css')
            ->addJsFile('js/admin-custom.js')
            ->addJsFile('js/enhanced-interactions.js')
            ->addJsFile('js/locale-switcher.js');
    }

    public function configureMenuItems(): iterable
    {
        // Récupérer les statistiques une seule fois
        $globalStats = $this->statsService->getGlobalStats();

        yield MenuItem::linkToDashboard('menu.dashboard', 'fa fa-chart-line');

        yield MenuItem::section('menu.students_classes');
        yield MenuItem::linkToCrud('entity.students', 'fa fa-user-graduate', Etudiant::class)
            ->setBadge($globalStats['totalEtudiants'], 'info');
        yield MenuItem::linkToCrud('entity.classes', 'fa fa-school', Classe::class)
            ->setBadge($globalStats['totalClasses'], 'success');
        yield MenuItem::linkToCrud('entity.absences', 'fa fa-calendar-times', Absence::class)
            ->setBadge($globalStats['totalAbsences'], 'warning');

        yield MenuItem::section('menu.teachers');
        yield MenuItem::linkToCrud('entity.professors', 'fa fa-chalkboard-teacher', Prof::class)
            ->setBadge($globalStats['totalProfesseurs'], 'info');
        yield MenuItem::linkToCrud('entity.sessions', 'fa fa-calendar-alt', Seance::class)
            ->setBadge($globalStats['totalSeances'], 'primary');

        yield MenuItem::section('menu.evaluations');
        yield MenuItem::linkToCrud('entity.evaluations', 'fa fa-clipboard-check', Evaluation::class)
            ->setBadge($globalStats['totalEvaluations'], 'success');
        yield MenuItem::linkToCrud('entity.grades', 'fa fa-star', Note::class);
        yield MenuItem::linkToCrud('entity.exercises', 'fa fa-tasks', Exercice::class);

        yield MenuItem::section();
        yield MenuItem::linkToUrl('menu.logout', 'fa fa-sign-out-alt', '/logout');
    }
}
