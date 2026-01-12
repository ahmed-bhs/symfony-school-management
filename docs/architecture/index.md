---
layout: default
title: Architecture
nav_order: 4
has_children: true
---

# Architecture

Understanding the School Management System architecture.

## Overview

This application follows **Symfony best practices** and uses a **Model-View-Controller (MVC)** architecture with:

- **Entities** - Domain models (database entities)
- **Controllers** - Handle HTTP requests
- **Templates** - Twig views for rendering
- **Services** - Business logic layer
- **Repositories** - Database queries

## Architecture Patterns

- **MVC (Model-View-Controller)** - Separates concerns
- **Repository Pattern** - Data access abstraction
- **Dependency Injection** - Service container
- **Event-Driven** - Event listeners and subscribers

## Technology Stack

**Backend**
- Symfony 7.4 (PHP framework)
- Doctrine ORM (database)
- PHP 8.3 (language)

**Frontend**
- Twig (templates)
- Bootstrap 5 (UI)
- Chart.js (charts)

**Admin**
- EasyAdmin 4 (CRUD generator)

## Project Structure

```
src/
├── Controller/        # HTTP controllers
│   └── Admin/        # EasyAdmin CRUD controllers
├── Entity/           # Doctrine entities
├── Repository/       # Database repositories
├── Service/          # Business logic services
├── EventListener/    # Event listeners
└── DataFixtures/     # Demo data fixtures
```

[Learn more about the project structure →](structure.md)
