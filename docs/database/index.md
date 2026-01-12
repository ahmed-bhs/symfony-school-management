---
layout: default
title: Database
nav_order: 5
has_children: true
---

# Database

Understanding the database schema and entity relationships.

## Database Schema

The School Management System uses MySQL 8 with the following main entities:

### Core Entities

- **Student (Etudiant)** - Student information
- **Class (Classe)** - Class/grade levels
- **Professor (Prof)** - Teaching staff
- **Session (Seance)** - Scheduled classes
- **Evaluation** - Tests and exams
- **Grade (Note)** - Student grades
- **Absence** - Attendance tracking
- **User** - System users

## Entity Relationships

```
┌─────────────┐       ┌──────────┐       ┌────────────┐
│   Student   │──────▶│  Class   │◀──────│  Session   │
└─────────────┘       └──────────┘       └────────────┘
       │                                         │
       │                                         │
       ▼                                         ▼
┌─────────────┐                          ┌────────────┐
│   Absence   │                          │ Professor  │
└─────────────┘                          └────────────┘
       │                                         │
       │                                         │
       ▼                                         ▼
┌─────────────┐                          ┌────────────┐
│    Grade    │◀─────────────────────────│ Evaluation │
└─────────────┘                          └────────────┘
```

## Relationships

- **Student → Class**: ManyToOne (many students in one class)
- **Class → Sessions**: OneToMany (class has many sessions)
- **Professor → Sessions**: OneToMany (professor teaches many sessions)
- **Session → Evaluations**: OneToMany (session has many evaluations)
- **Evaluation → Grades**: OneToMany (evaluation has many grades)
- **Student → Grades**: OneToMany (student has many grades)
- **Student → Absences**: OneToMany (student has many absences)

[Learn more about entities →](entities.md)

## Migrations

Database schema is managed with Doctrine Migrations:

```bash
# Create migration
php bin/console make:migration

# Execute migrations
php bin/console doctrine:migrations:migrate

# View migration status
php bin/console doctrine:migrations:status
```

[Learn more about migrations →](migrations.md)
