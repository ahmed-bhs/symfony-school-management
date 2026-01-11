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
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Gestion Scolaire')
            ->setFaviconPath('favicon.ico');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');

        yield MenuItem::section('Étudiants & Classes');
        yield MenuItem::linkToCrud('Étudiants', 'fa fa-user-graduate', Etudiant::class);
        yield MenuItem::linkToCrud('Classes', 'fa fa-school', Classe::class);
        yield MenuItem::linkToCrud('Absences', 'fa fa-calendar-times', Absence::class);

        yield MenuItem::section('Enseignants');
        yield MenuItem::linkToCrud('Professeurs', 'fa fa-chalkboard-teacher', Prof::class);
        yield MenuItem::linkToCrud('Séances', 'fa fa-calendar-alt', Seance::class);

        yield MenuItem::section('Évaluations');
        yield MenuItem::linkToCrud('Évaluations', 'fa fa-clipboard-check', Evaluation::class);
        yield MenuItem::linkToCrud('Notes', 'fa fa-star', Note::class);
        yield MenuItem::linkToCrud('Exercices', 'fa fa-tasks', Exercice::class);
    }
}
