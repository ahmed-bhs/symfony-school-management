<?php

namespace App\Controller\Admin;

use App\Entity\Classe;
use App\Entity\Evaluation;
use App\Entity\Note;
use App\Repository\ClasseRepository;
use App\Repository\EvaluationRepository;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/admin/mass-grade-entry')]
class MassGradeEntryController extends AbstractController
{
    public function __construct(
        private ClasseRepository $classeRepository,
        private EvaluationRepository $evaluationRepository,
        private NoteRepository $noteRepository,
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator
    ) {
    }

    #[Route('/select-class', name: 'admin_mass_grade_select_class')]
    public function selectClass(): Response
    {
        $classes = $this->classeRepository->findAll();

        return $this->render('admin/mass_grade/select_class.html.twig', [
            'classes' => $classes,
        ]);
    }

    #[Route('/select-evaluation/{classeId}', name: 'admin_mass_grade_select_evaluation')]
    public function selectEvaluation(int $classeId): Response
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

    #[Route('/enter-grades/{evaluationId}', name: 'admin_mass_grade_enter')]
    public function enterGrades(int $evaluationId, Request $request): Response
    {
        $evaluation = $this->evaluationRepository->find($evaluationId);

        if (!$evaluation) {
            throw $this->createNotFoundException('Évaluation non trouvée');
        }

        $classe = $evaluation->getClasse();
        $etudiants = $classe->getEtudiants();

        // Récupérer les notes existantes pour cette évaluation
        $existingNotes = [];
        foreach ($this->noteRepository->findBy(['evaluation' => $evaluation]) as $note) {
            $existingNotes[$note->getEtudiant()->getId()] = $note;
        }

        // Traitement du formulaire
        if ($request->isMethod('POST')) {
            $grades = $request->request->all('grades');

            foreach ($etudiants as $etudiant) {
                $gradeValue = $grades[$etudiant->getId()] ?? null;

                // Si une note est saisie
                if ($gradeValue !== null && $gradeValue !== '') {
                    $gradeValue = (float) $gradeValue;

                    // Vérifier si une note existe déjà
                    if (isset($existingNotes[$etudiant->getId()])) {
                        // Mettre à jour
                        $note = $existingNotes[$etudiant->getId()];
                        $note->setValeur($gradeValue);
                    } else {
                        // Créer nouvelle note
                        $note = new Note();
                        $note->setEtudiant($etudiant);
                        $note->setEvaluation($evaluation);
                        $note->setClasse($classe);
                        $note->setValeur($gradeValue);
                        $this->entityManager->persist($note);
                    }
                } elseif (isset($existingNotes[$etudiant->getId()])) {
                    // Si le champ est vide et qu'une note existait, la supprimer
                    $this->entityManager->remove($existingNotes[$etudiant->getId()]);
                }
            }

            $this->entityManager->flush();

            $this->addFlash('success', $this->translator->trans('mass_grade.success', [], 'messages'));

            // Rediriger vers la même page pour continuer à éditer
            return $this->redirectToRoute('admin_mass_grade_enter', ['evaluationId' => $evaluationId]);
        }

        return $this->render('admin/mass_grade/enter_grades.html.twig', [
            'evaluation' => $evaluation,
            'classe' => $classe,
            'etudiants' => $etudiants,
            'existingNotes' => $existingNotes,
        ]);
    }
}
