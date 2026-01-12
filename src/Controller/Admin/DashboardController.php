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
use App\Repository\ClasseRepository;
use App\Repository\EvaluationRepository;
use App\Repository\NoteRepository;
use App\Service\DashboardStatsService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private DashboardStatsService $statsService,
        private TranslatorInterface $translator,
        private ClasseRepository $classeRepository,
        private EvaluationRepository $evaluationRepository,
        private NoteRepository $noteRepository,
        private EntityManagerInterface $entityManager
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

    #[Route('/admin/mass-grade/select-class', name: 'admin_mass_grade_select_class')]
    public function massGradeSelectClass(): Response
    {
        $classes = $this->classeRepository->findAll();

        return $this->render('admin/mass_grade/select_class.html.twig', [
            'classes' => $classes,
        ]);
    }

    #[Route('/admin/mass-grade/select-evaluation/{classeId}', name: 'admin_mass_grade_select_evaluation')]
    public function massGradeSelectEvaluation(int $classeId): Response
    {
        $classe = $this->classeRepository->find($classeId);

        if (!$classe) {
            throw $this->createNotFoundException('Classe non trouvée');
        }

        $evaluations = $this->evaluationRepository->findBy(['classe' => $classe], ['date' => 'DESC']);

        return $this->render('admin/mass_grade/select_evaluation.html.twig', [
            'classe' => $classe,
            'evaluations' => $evaluations,
        ]);
    }

    #[Route('/admin/mass-grade/enter-grades/{evaluationId}', name: 'admin_mass_grade_enter')]
    public function massGradeEnter(int $evaluationId, Request $request): Response
    {
        $evaluation = $this->evaluationRepository->find($evaluationId);

        if (!$evaluation) {
            throw $this->createNotFoundException('Évaluation non trouvée');
        }

        $classe = $evaluation->getClasse();
        $etudiants = $classe->getEtudiants();

        // Récupérer les notes existantes
        $existingNotes = [];
        foreach ($this->noteRepository->findBy(['evaluation' => $evaluation]) as $note) {
            $existingNotes[$note->getEtudiant()->getId()] = $note;
        }

        // Traitement du formulaire
        if ($request->isMethod('POST')) {
            $grades = $request->request->all('grades');

            foreach ($etudiants as $etudiant) {
                $gradeValue = $grades[$etudiant->getId()] ?? null;

                if ($gradeValue !== null && $gradeValue !== '') {
                    $gradeValue = (float) $gradeValue;

                    if (isset($existingNotes[$etudiant->getId()])) {
                        $note = $existingNotes[$etudiant->getId()];
                        $note->setValeur($gradeValue);
                    } else {
                        $note = new Note();
                        $note->setEtudiant($etudiant);
                        $note->setEvaluation($evaluation);
                        $note->setClasse($classe);
                        $note->setValeur($gradeValue);
                        $this->entityManager->persist($note);
                    }
                } elseif (isset($existingNotes[$etudiant->getId()])) {
                    $this->entityManager->remove($existingNotes[$etudiant->getId()]);
                }
            }

            $this->entityManager->flush();

            $this->addFlash('success', $this->translator->trans('mass_grade.success', [], 'messages'));

            return $this->redirectToRoute('admin_mass_grade_enter', ['evaluationId' => $evaluationId]);
        }

        return $this->render('admin/mass_grade/enter_grades.html.twig', [
            'evaluation' => $evaluation,
            'classe' => $classe,
            'etudiants' => $etudiants,
            'existingNotes' => $existingNotes,
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
            ->addCssFile('css/class-selection.css')
            ->addCssFile('css/mass-grade-entry.css')
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
        yield MenuItem::linkToRoute('entity.students', 'fa fa-user-graduate', 'admin_class_selection_students')
            ->setBadge($globalStats['totalEtudiants'], 'info');
        yield MenuItem::linkToCrud('entity.classes', 'fa fa-school', Classe::class)
            ->setBadge($globalStats['totalClasses'], 'success');
        yield MenuItem::linkToCrud('entity.absences', 'fa fa-calendar-times', Absence::class)
            ->setBadge($globalStats['totalAbsences'], 'warning');

        yield MenuItem::section('menu.teachers');
        yield MenuItem::linkToCrud('entity.professors', 'fa fa-chalkboard-teacher', Prof::class)
            ->setBadge($globalStats['totalProfesseurs'], 'info');
        yield MenuItem::linkToRoute('entity.sessions', 'fa fa-calendar-alt', 'admin_class_selection_sessions')
            ->setBadge($globalStats['totalSeances'], 'primary');

        yield MenuItem::section('menu.evaluations');
        yield MenuItem::linkToRoute('entity.evaluations', 'fa fa-clipboard-check', 'admin_class_selection_evaluations')
            ->setBadge($globalStats['totalEvaluations'], 'success');
        yield MenuItem::linkToRoute('entity.grades', 'fa fa-star', 'admin_class_selection_grades');
        yield MenuItem::linkToRoute('entity.exercises', 'fa fa-tasks', 'admin_class_selection_exercises');

        yield MenuItem::section();
        yield MenuItem::linkToUrl('menu.logout', 'fa fa-sign-out-alt', '/logout');
    }
}
