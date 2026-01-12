<?php

namespace App\Controller\Admin;

use App\Entity\Classe;
use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/admin/class-selection')]
class ClassSelectionController extends AbstractController
{
    public function __construct(
        private ClasseRepository $classeRepository,
        private TranslatorInterface $translator
    ) {
    }

    #[Route('/students', name: 'admin_class_selection_students')]
    public function studentsSelection(): Response
    {
        return $this->renderClassSelection('entity.students', 'Etudiant');
    }

    #[Route('/sessions', name: 'admin_class_selection_sessions')]
    public function sessionsSelection(): Response
    {
        return $this->renderClassSelection('entity.sessions', 'Seance');
    }

    #[Route('/evaluations', name: 'admin_class_selection_evaluations')]
    public function evaluationsSelection(): Response
    {
        return $this->renderClassSelection('entity.evaluations', 'Evaluation');
    }

    #[Route('/grades', name: 'admin_class_selection_grades')]
    public function gradesSelection(): Response
    {
        return $this->renderClassSelection('entity.grades', 'Note');
    }

    #[Route('/exercises', name: 'admin_class_selection_exercises')]
    public function exercisesSelection(): Response
    {
        return $this->renderClassSelection('entity.exercises', 'Exercice');
    }

    private function renderClassSelection(string $entityLabel, string $entityName): Response
    {
        $classes = $this->classeRepository->findAll();

        // Calculate statistics for each class
        $classesWithStats = [];
        foreach ($classes as $classe) {
            $count = match ($entityName) {
                'Etudiant' => $classe->getEtudiants()->count(),
                'Seance' => $classe->getSeances()->count(),
                'Evaluation' => $classe->getEvaluations()->count(),
                'Note' => $classe->getNotes()->count(),
                'Exercice' => $classe->getExercices()->count(),
                default => 0,
            };

            $classesWithStats[] = [
                'classe' => $classe,
                'count' => $count,
            ];
        }

        return $this->render('admin/class_selection.html.twig', [
            'classes' => $classesWithStats,
            'entity_label' => $this->translator->trans($entityLabel, [], 'messages'),
            'entity_name' => $entityName,
        ]);
    }
}
