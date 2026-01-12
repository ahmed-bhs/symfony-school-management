---
layout: default
title: Entities
parent: Database
nav_order: 1
---

# Database Entities

Complete reference for all entities in the School Management System.

---

## Overview

The system has **8 main entities** representing the core domain model:

1. **Student (Etudiant)** - Student information
2. **Class (Classe)** - Class/grade levels
3. **Professor (Prof)** - Teaching staff
4. **Session (Seance)** - Scheduled classes
5. **Evaluation** - Tests and exams
6. **Grade (Note)** - Student grades
7. **Absence** - Attendance records
8. **User** - System users

---

## Student (Etudiant)

Represents a student enrolled in the school.

### Properties

| Field | Type | Description | Required |
|-------|------|-------------|----------|
| `id` | integer | Primary key | Auto |
| `nom` | string(100) | Last name | Yes |
| `prenom` | string(100) | First name | Yes |
| `dateNaissance` | date | Birth date | Yes |
| `adresse` | text | Address | No |
| `nomPere` | string(100) | Father's name | No |
| `telephonePere` | string(20) | Father's phone | No |
| `nomMere` | string(100) | Mother's name | No |
| `telephoneMere` | string(20) | Mother's phone | No |
| `classe` | Classe | Assigned class | No |

### Relationships

- **ManyToOne** with `Classe` - Student belongs to one class
- **OneToMany** with `Note` - Student has many grades
- **OneToMany** with `Absence` - Student has many absences

### Entity Definition

```php
#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
#[ORM\Table(name: 'etudiant')]
class Etudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    private string $nom;

    #[ORM\Column(type: 'string', length: 100)]
    private string $prenom;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $dateNaissance;

    #[ORM\ManyToOne(targetEntity: Classe::class, inversedBy: 'etudiants')]
    private ?Classe $classe = null;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Note::class, cascade: ['remove'])]
    private Collection $notes;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Absence::class, cascade: ['remove'])]
    private Collection $absences;
}
```

---

## Class (Classe)

Represents a class or grade level.

### Properties

| Field | Type | Description | Required |
|-------|------|-------------|----------|
| `id` | integer | Primary key | Auto |
| `nom` | string(100) | Class name (e.g., "6th Grade A") | Yes |
| `annee` | string(50) | School year (e.g., "2025-2026") | Yes |

### Relationships

- **OneToMany** with `Etudiant` - Class has many students
- **OneToMany** with `Seance` - Class has many sessions

### Entity Definition

```php
#[ORM\Entity(repositoryClass: ClasseRepository::class)]
#[ORM\Table(name: 'classe')]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    private string $nom;

    #[ORM\Column(type: 'string', length: 50)]
    private string $annee;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Etudiant::class)]
    private Collection $etudiants;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Seance::class)]
    private Collection $seances;
}
```

---

## Professor (Prof)

Represents a teaching staff member.

### Properties

| Field | Type | Description | Required |
|-------|------|-------------|----------|
| `id` | integer | Primary key | Auto |
| `nom` | string(100) | Last name | Yes |
| `prenom` | string(100) | First name | Yes |
| `telephone` | string(20) | Phone number | No |
| `competences` | text | Competencies | No |
| `skills` | text | Skills and subjects | No |

### Relationships

- **OneToMany** with `Seance` - Professor teaches many sessions
- **OneToMany** with `Evaluation` - Professor creates many evaluations

### Entity Definition

```php
#[ORM\Entity(repositoryClass: ProfRepository::class)]
#[ORM\Table(name: 'prof')]
class Prof
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    private string $nom;

    #[ORM\Column(type: 'string', length: 100)]
    private string $prenom;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\OneToMany(mappedBy: 'prof', targetEntity: Seance::class)]
    private Collection $seances;
}
```

---

## Session (Seance)

Represents a scheduled class session.

### Properties

| Field | Type | Description | Required |
|-------|------|-------------|----------|
| `id` | integer | Primary key | Auto |
| `jour` | string(20) | Day of week | Yes |
| `heureDebut` | time | Start time | Yes |
| `heureFin` | time | End time | Yes |
| `matiere` | string(100) | Subject | No |
| `classe` | Classe | Class | Yes |
| `prof` | Prof | Professor | Yes |

### Relationships

- **ManyToOne** with `Classe` - Session belongs to one class
- **ManyToOne** with `Prof` - Session taught by one professor
- **OneToMany** with `Evaluation` - Session has many evaluations
- **OneToMany** with `Absence` - Session has many absences

### Entity Definition

```php
#[ORM\Entity(repositoryClass: SeanceRepository::class)]
#[ORM\Table(name: 'seance')]
class Seance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 20)]
    private string $jour;

    #[ORM\Column(type: 'time')]
    private \DateTimeInterface $heureDebut;

    #[ORM\Column(type: 'time')]
    private \DateTimeInterface $heureFin;

    #[ORM\ManyToOne(targetEntity: Classe::class, inversedBy: 'seances')]
    #[ORM\JoinColumn(nullable: false)]
    private Classe $classe;

    #[ORM\ManyToOne(targetEntity: Prof::class, inversedBy: 'seances')]
    #[ORM\JoinColumn(nullable: false)]
    private Prof $prof;
}
```

---

## Evaluation

Represents a test, quiz, or exam.

### Properties

| Field | Type | Description | Required |
|-------|------|-------------|----------|
| `id` | integer | Primary key | Auto |
| `titre` | string(200) | Title | Yes |
| `type` | string(50) | Type (Test, Quiz, Exam) | No |
| `coefficient` | integer | Weight coefficient | Yes |
| `date` | date | Evaluation date | Yes |
| `seance` | Seance | Related session | Yes |

### Relationships

- **ManyToOne** with `Seance` - Evaluation belongs to one session
- **OneToMany** with `Note` - Evaluation has many grades

### Entity Definition

```php
#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
#[ORM\Table(name: 'evaluation')]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 200)]
    private string $titre;

    #[ORM\Column(type: 'integer')]
    private int $coefficient;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $date;

    #[ORM\ManyToOne(targetEntity: Seance::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Seance $seance;

    #[ORM\OneToMany(mappedBy: 'evaluation', targetEntity: Note::class, cascade: ['remove'])]
    private Collection $notes;
}
```

---

## Grade (Note)

Represents a student's grade for an evaluation.

### Properties

| Field | Type | Description | Required |
|-------|------|-------------|----------|
| `id` | integer | Primary key | Auto |
| `valeur` | float | Grade value (0-20) | Yes |
| `etudiant` | Etudiant | Student | Yes |
| `evaluation` | Evaluation | Evaluation | Yes |

### Relationships

- **ManyToOne** with `Etudiant` - Grade belongs to one student
- **ManyToOne** with `Evaluation` - Grade belongs to one evaluation

### Entity Definition

```php
#[ORM\Entity(repositoryClass: NoteRepository::class)]
#[ORM\Table(name: 'note')]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'float')]
    private float $valeur;

    #[ORM\ManyToOne(targetEntity: Etudiant::class, inversedBy: 'notes')]
    #[ORM\JoinColumn(nullable: false)]
    private Etudiant $etudiant;

    #[ORM\ManyToOne(targetEntity: Evaluation::class, inversedBy: 'notes')]
    #[ORM\JoinColumn(nullable: false)]
    private Evaluation $evaluation;
}
```

---

## Absence

Represents a student absence record.

### Properties

| Field | Type | Description | Required |
|-------|------|-------------|----------|
| `id` | integer | Primary key | Auto |
| `justifie` | boolean | Is justified | Yes |
| `raison` | text | Reason | No |
| `etudiant` | Etudiant | Student | Yes |
| `seance` | Seance | Session missed | Yes |

### Relationships

- **ManyToOne** with `Etudiant` - Absence belongs to one student
- **ManyToOne** with `Seance` - Absence for one session

### Entity Definition

```php
#[ORM\Entity(repositoryClass: AbsenceRepository::class)]
#[ORM\Table(name: 'absence')]
class Absence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'boolean')]
    private bool $justifie = false;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $raison = null;

    #[ORM\ManyToOne(targetEntity: Etudiant::class, inversedBy: 'absences')]
    #[ORM\JoinColumn(nullable: false)]
    private Etudiant $etudiant;

    #[ORM\ManyToOne(targetEntity: Seance::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Seance $seance;
}
```

---

## User

Represents a system user for authentication.

### Properties

| Field | Type | Description | Required |
|-------|------|-------------|----------|
| `id` | integer | Primary key | Auto |
| `username` | string(180) | Username | Yes |
| `roles` | json | User roles | Yes |
| `password` | string | Hashed password | Yes |

### Entity Definition

```php
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $username;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    private string $password;
}
```

---

## Entity Relationships Diagram

```
┌──────────────┐
│   Student    │
│  (Etudiant)  │
└──────┬───────┘
       │
       │ ManyToOne
       ▼
┌──────────────┐       OneToMany      ┌──────────────┐
│    Class     │◀──────────────────────│   Session    │
│   (Classe)   │                       │   (Seance)   │
└──────────────┘                       └──────┬───────┘
                                              │
                                              │ ManyToOne
                                              ▼
                                       ┌──────────────┐
                                       │  Professor   │
                                       │    (Prof)    │
                                       └──────────────┘
       │
       │ OneToMany
       ▼
┌──────────────┐       ManyToOne      ┌──────────────┐
│    Grade     │──────────────────────▶│  Evaluation  │
│    (Note)    │                       └──────────────┘
└──────────────┘
       │
       │ ManyToOne
       ▼
┌──────────────┐
│   Absence    │
└──────────────┘
```

---

## Database Conventions

### Naming Conventions

- **Table names**: lowercase, French names (etudiant, classe, seance)
- **Column names**: camelCase in PHP, snake_case in database
- **Foreign keys**: `{table}_id` format
- **Junction tables**: `{table1}_{table2}` format

### Data Types

- **IDs**: Integer, auto-increment
- **Strings**: VARCHAR with appropriate length
- **Text**: TEXT for long content
- **Dates**: DATE or DATETIME as appropriate
- **Booleans**: TINYINT(1)
- **Decimals**: FLOAT or DECIMAL for grades

### Constraints

- **Primary Keys**: All entities have auto-increment ID
- **Foreign Keys**: All relationships have FK constraints
- **Unique**: Username in User entity
- **NOT NULL**: Most required fields
- **Cascade**: Delete cascades for grades and absences

---

## Working with Entities

### Creating Entities

```bash
# Using Maker bundle
php bin/console make:entity

# Follow prompts to add fields
```

### Updating Schema

```bash
# Generate migration
php bin/console make:migration

# Apply migration
php bin/console doctrine:migrations:migrate
```

### Validating Schema

```bash
# Check if schema matches entities
php bin/console doctrine:schema:validate
```

---

**Next:** [Database Migrations →](migrations.md)
