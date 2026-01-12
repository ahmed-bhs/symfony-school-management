<?php

namespace App\Service;

use App\Repository\AbsenceRepository;
use App\Repository\ClasseRepository;
use App\Repository\EtudiantRepository;
use App\Repository\EvaluationRepository;
use App\Repository\NoteRepository;
use App\Repository\ProfRepository;
use App\Repository\SeanceRepository;
use Doctrine\ORM\EntityManagerInterface;

class DashboardStatsService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EtudiantRepository $etudiantRepository,
        private ClasseRepository $classeRepository,
        private ProfRepository $profRepository,
        private AbsenceRepository $absenceRepository,
        private EvaluationRepository $evaluationRepository,
        private NoteRepository $noteRepository,
        private SeanceRepository $seanceRepository
    ) {
    }

    public function getGlobalStats(): array
    {
        return [
            'totalEtudiants' => $this->etudiantRepository->count([]),
            'totalClasses' => $this->classeRepository->count([]),
            'totalProfesseurs' => $this->profRepository->count([]),
            'totalEvaluations' => $this->evaluationRepository->count([]),
            'totalAbsences' => $this->absenceRepository->count([]),
            'totalSeances' => $this->seanceRepository->count([]),
        ];
    }

    public function getEtudiantsStats(): array
    {
        $total = $this->etudiantRepository->count([]);
        $actifs = $this->etudiantRepository->count(['status' => true]);
        $inactifs = $this->etudiantRepository->count(['status' => false]);

        // Statistiques par genre
        $connection = $this->entityManager->getConnection();
        $genreStats = $connection->executeQuery(
            'SELECT genre, COUNT(*) as count FROM etudiant GROUP BY genre'
        )->fetchAllAssociative();

        return [
            'total' => $total,
            'actifs' => $actifs,
            'inactifs' => $inactifs,
            'pourcentageActifs' => $total > 0 ? round(($actifs / $total) * 100, 2) : 0,
            'genreStats' => $genreStats,
        ];
    }

    public function getClassesStats(): array
    {
        $connection = $this->entityManager->getConnection();

        // Nombre d'étudiants par classe
        $classesAvecEtudiants = $connection->executeQuery(
            'SELECT c.id, c.description, c.annee, COUNT(e.id) as nb_etudiants
             FROM classe c
             LEFT JOIN etudiant e ON e.classe_id = c.id
             GROUP BY c.id, c.description, c.annee
             ORDER BY nb_etudiants DESC
             LIMIT 5'
        )->fetchAllAssociative();

        $avgEtudiantsParClasse = $connection->executeQuery(
            'SELECT AVG(nb_etudiants) as moyenne
             FROM (
                 SELECT COUNT(e.id) as nb_etudiants
                 FROM classe c
                 LEFT JOIN etudiant e ON e.classe_id = c.id
                 GROUP BY c.id
             ) as subquery'
        )->fetchAssociative();

        return [
            'topClasses' => $classesAvecEtudiants,
            'moyenneEtudiantsParClasse' => round($avgEtudiantsParClasse['moyenne'] ?? 0, 2),
        ];
    }

    public function getNotesStats(): array
    {
        $connection = $this->entityManager->getConnection();

        // Moyenne générale
        $moyenneGenerale = $connection->executeQuery(
            'SELECT AVG(valeur) as moyenne FROM note WHERE valeur IS NOT NULL'
        )->fetchAssociative();

        // Distribution des notes
        $distribution = $connection->executeQuery(
            'SELECT
                SUM(CASE WHEN valeur >= 16 THEN 1 ELSE 0 END) as excellent,
                SUM(CASE WHEN valeur >= 14 AND valeur < 16 THEN 1 ELSE 0 END) as bien,
                SUM(CASE WHEN valeur >= 12 AND valeur < 14 THEN 1 ELSE 0 END) as assez_bien,
                SUM(CASE WHEN valeur >= 10 AND valeur < 12 THEN 1 ELSE 0 END) as passable,
                SUM(CASE WHEN valeur < 10 THEN 1 ELSE 0 END) as insuffisant,
                COUNT(*) as total
             FROM note WHERE valeur IS NOT NULL'
        )->fetchAssociative();

        // Top 5 étudiants
        $topEtudiants = $connection->executeQuery(
            'SELECT e.nom, e.prenom, AVG(n.valeur) as moyenne
             FROM etudiant e
             INNER JOIN note n ON n.etudiant_id = e.id
             WHERE n.valeur IS NOT NULL
             GROUP BY e.id, e.nom, e.prenom
             ORDER BY moyenne DESC
             LIMIT 5'
        )->fetchAllAssociative();

        return [
            'moyenneGenerale' => round($moyenneGenerale['moyenne'] ?? 0, 2),
            'distribution' => $distribution,
            'topEtudiants' => $topEtudiants,
        ];
    }

    public function getAbsencesStats(): array
    {
        $connection = $this->entityManager->getConnection();

        // Total des absences
        $totalAbsences = $connection->executeQuery(
            'SELECT SUM(nombre) as total FROM absence'
        )->fetchAssociative();

        // Étudiants avec le plus d'absences
        $topAbsences = $connection->executeQuery(
            'SELECT e.nom, e.prenom, SUM(a.nombre) as total_absences
             FROM etudiant e
             INNER JOIN absence a ON a.etudiant_id = e.id
             GROUP BY e.id, e.nom, e.prenom
             ORDER BY total_absences DESC
             LIMIT 5'
        )->fetchAllAssociative();

        // Taux d'absentéisme
        $totalEtudiants = $this->etudiantRepository->count([]);
        $etudiantsAvecAbsences = $connection->executeQuery(
            'SELECT COUNT(DISTINCT etudiant_id) as count FROM absence'
        )->fetchAssociative();

        return [
            'totalAbsences' => $totalAbsences['total'] ?? 0,
            'topAbsences' => $topAbsences,
            'tauxAbsenteisme' => $totalEtudiants > 0
                ? round(($etudiantsAvecAbsences['count'] / $totalEtudiants) * 100, 2)
                : 0,
        ];
    }

    public function getProfesseursStats(): array
    {
        $connection = $this->entityManager->getConnection();

        // Répartition par compétences
        $competencesStats = $connection->executeQuery(
            'SELECT competences, COUNT(*) as count
             FROM prof
             GROUP BY competences
             ORDER BY count DESC'
        )->fetchAllAssociative();

        // Professeurs avec le plus de séances
        $topProfs = $connection->executeQuery(
            'SELECT p.nom, p.prenom, p.competences, COUNT(s.id) as nb_seances
             FROM prof p
             LEFT JOIN seance s ON s.prof_id = p.id
             GROUP BY p.id, p.nom, p.prenom, p.competences
             ORDER BY nb_seances DESC
             LIMIT 5'
        )->fetchAllAssociative();

        return [
            'competencesStats' => $competencesStats,
            'topProfs' => $topProfs,
        ];
    }

    public function getRecentActivity(): array
    {
        $connection = $this->entityManager->getConnection();

        // Dernières évaluations
        $recentEvaluations = $connection->executeQuery(
            'SELECT e.nom, e.date, c.description as classe
             FROM evaluation e
             LEFT JOIN classe c ON c.id = e.classe_id
             ORDER BY e.date DESC
             LIMIT 5'
        )->fetchAllAssociative();

        // Prochaines séances
        $upcomingSeances = $connection->executeQuery(
            'SELECT s.description, s.date, s.debut, c.description as classe, p.nom as prof_nom, p.prenom as prof_prenom
             FROM seance s
             LEFT JOIN classe c ON c.id = s.classe_id
             LEFT JOIN prof p ON p.id = s.prof_id
             WHERE s.date >= CURDATE()
             ORDER BY s.date ASC, s.debut ASC
             LIMIT 5'
        )->fetchAllAssociative();

        return [
            'recentEvaluations' => $recentEvaluations,
            'upcomingSeances' => $upcomingSeances,
        ];
    }

    public function getAllStats(): array
    {
        return [
            'global' => $this->getGlobalStats(),
            'etudiants' => $this->getEtudiantsStats(),
            'classes' => $this->getClassesStats(),
            'notes' => $this->getNotesStats(),
            'absences' => $this->getAbsencesStats(),
            'professeurs' => $this->getProfesseursStats(),
            'activity' => $this->getRecentActivity(),
        ];
    }
}
