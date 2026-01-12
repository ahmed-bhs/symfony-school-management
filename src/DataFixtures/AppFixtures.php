<?php

namespace App\DataFixtures;

use App\Entity\Absence;
use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Entity\Evaluation;
use App\Entity\Exercice;
use App\Entity\Note;
use App\Entity\Prof;
use App\Entity\Seance;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $faker;
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->faker = Factory::create('fr_FR');
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // 1. Créer un utilisateur admin
        $admin = new User();
        $admin->setEmail('admin@ecole.com');
        $admin->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin'));
        $manager->persist($admin);

        // 2. Créer des classes
        $classes = [];
        $niveaux = ['6ème', '5ème', '4ème', '3ème', '2nde', '1ère', 'Terminale'];

        foreach ($niveaux as $niveau) {
            for ($section = 1; $section <= 3; $section++) {
                $classe = new Classe();
                $classe->setDescription($niveau . ' - Section ' . $section);
                $classe->setAnnee('2025-2026');
                $manager->persist($classe);
                $classes[] = $classe;
            }
        }

        // 3. Créer des professeurs
        $profs = [];
        $matieres = ['Mathématiques', 'Français', 'Anglais', 'Histoire-Géographie', 'Sciences Physiques', 'SVT', 'EPS', 'Arts Plastiques'];

        foreach ($matieres as $matiere) {
            for ($i = 0; $i < 2; $i++) {
                $prof = new Prof();
                $prof->setNom($this->faker->lastName());
                $prof->setPrenom($this->faker->firstName());
                $prof->setCin($this->faker->numberBetween(10000000, 99999999));
                $prof->setDateNaissance($this->faker->dateTimeBetween('-50 years', '-25 years'));
                $prof->setGenre($this->faker->randomElement(['M', 'F']));
                $prof->setEmail($this->faker->email());
                $prof->setCompetences($matiere . ', ' . $this->faker->words(3, true));
                $prof->setAdresse($this->faker->address());
                $prof->setNumeroTel($this->faker->numberBetween(600000000, 799999999));
                $prof->setDebut($this->faker->dateTimeBetween('-10 years', '-1 year'));
                $prof->setFin($this->faker->dateTimeBetween('+1 year', '+10 years'));
                $manager->persist($prof);
                $profs[] = $prof;
            }
        }

        // 4. Créer des étudiants
        $etudiants = [];
        foreach ($classes as $classe) {
            $nombreEtudiants = $this->faker->numberBetween(15, 30);

            for ($i = 0; $i < $nombreEtudiants; $i++) {
                $etudiant = new Etudiant();
                $etudiant->setNom($this->faker->lastName());
                $etudiant->setPrenom($this->faker->firstName());
                $etudiant->setDateNaissance($this->faker->dateTimeBetween('-18 years', '-10 years'));
                $etudiant->setGenre($this->faker->randomElement(['M', 'F']));
                $etudiant->setAdresse($this->faker->address());
                $etudiant->setNomPere($this->faker->firstNameMale() . ' ' . $etudiant->getNom());
                $etudiant->setNomMere($this->faker->firstNameFemale() . ' ' . $this->faker->lastName());
                $etudiant->setNumeroTel($this->faker->numberBetween(600000000, 799999999));
                $etudiant->setStatus(true);
                $etudiant->setClasse($classe);
                $manager->persist($etudiant);
                $etudiants[] = $etudiant;
            }
        }

        // 5. Créer des séances (emploi du temps)
        foreach ($classes as $classe) {
            $matieresClasse = $this->faker->randomElements($matieres, $this->faker->numberBetween(5, 8));

            foreach ($matieresClasse as $matiere) {
                $prof = $this->faker->randomElement($profs);
                $nombreSeances = $this->faker->numberBetween(2, 4);

                for ($j = 0; $j < $nombreSeances; $j++) {
                    $seance = new Seance();
                    $seance->setDescription($matiere);
                    $seance->setJour($this->faker->numberBetween(1, 5)); // Lundi à Vendredi
                    $seance->setDebut($this->faker->dateTimeThisMonth());
                    $seance->setFin($this->faker->dateTimeThisMonth());
                    $seance->setClasse($classe);
                    $seance->setProf($prof);
                    $manager->persist($seance);
                }
            }
        }

        // Flush intermédiaire pour s'assurer que les relations sont bien établies
        $manager->flush();

        // 6. Créer des évaluations et notes
        // Créer un tableau associatif classe_id => [etudiants]
        $etudiantsParClasse = [];
        foreach ($etudiants as $etudiant) {
            $classeId = $etudiant->getClasse()->getId();
            if (!isset($etudiantsParClasse[$classeId])) {
                $etudiantsParClasse[$classeId] = [];
            }
            $etudiantsParClasse[$classeId][] = $etudiant;
        }

        foreach ($classes as $classe) {
            $classeId = $classe->getId();
            $etudiantsClasse = $etudiantsParClasse[$classeId] ?? [];

            foreach (['1', '2'] as $semestre) {
                $nombreEvals = $this->faker->numberBetween(3, 6);

                for ($i = 0; $i < $nombreEvals; $i++) {
                    $evaluation = new Evaluation();
                    $evaluation->setDescription($this->faker->randomElement(['Contrôle', 'Devoir Surveillé', 'Examen']) . ' #' . ($i + 1));
                    $evaluation->setSemestre($semestre);
                    $evaluation->setCoef($this->faker->randomFloat(1, 1, 3));
                    $evaluation->setDate($this->faker->dateTimeThisYear());
                    $evaluation->setClasse($classe);
                    $evaluation->setProf($this->faker->randomElement($profs));
                    $manager->persist($evaluation);

                    // 7. Créer des notes pour cette évaluation
                    foreach ($etudiantsClasse as $etudiant) {
                        $note = new Note();
                        $note->setValeur($this->faker->randomFloat(2, 0, 20));
                        $note->setEvaluation($evaluation);
                        $note->setEtudiant($etudiant);
                        $note->setClasse($classe);
                        $manager->persist($note);
                    }
                }
            }
        }

        // 8. Créer des absences
        foreach ($etudiants as $etudiant) {
            if ($this->faker->boolean(30)) { // 30% des étudiants ont des absences
                $absence = new Absence();
                $absence->setNombre($this->faker->numberBetween(1, 15));
                $absence->setEtudiant($etudiant);
                $manager->persist($absence);
            }
        }

        // 9. Créer des exercices
        foreach ($classes as $classe) {
            $nombreExercices = $this->faker->numberBetween(5, 15);

            for ($i = 0; $i < $nombreExercices; $i++) {
                $exercice = new Exercice();
                $exercice->setDescription($this->faker->sentence(6));
                $exercice->setDate($this->faker->dateTimeThisYear());
                $exercice->setClasse($classe);
                $manager->persist($exercice);
            }
        }

        $manager->flush();
    }
}
