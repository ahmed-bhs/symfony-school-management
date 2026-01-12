---
layout: default
title: Development
nav_order: 6
has_children: true
---

# Development Guide

Guide for developers who want to contribute to or extend the School Management System.

## Overview

This section covers development workflows, coding standards, and best practices for working with the codebase.

## For Contributors

### Getting Started

1. [Development Setup](setup.md) - Set up your development environment
2. [Project Structure](structure.md) - Understand the codebase organization
3. [Coding Standards](standards.md) - Follow our coding conventions
4. [Testing](testing.md) - Write and run tests
5. [Contributing](contributing.md) - Submit your contributions

## Development Topics

### Core Development

- **Entities & Database** - Working with Doctrine ORM
- **Controllers** - Creating new pages and actions
- **Templates** - Twig templating
- **Services** - Business logic layer
- **Events** - Event listeners and subscribers

### Advanced Topics

- **Custom EasyAdmin Fields** - Extend the admin panel
- **Translations** - Add new languages
- **Performance** - Optimization techniques
- **Security** - Best practices
- **API Development** - REST/GraphQL endpoints

## Development Tools

### Available Commands

```bash
# Development server
symfony server:start

# Code quality
vendor/bin/phpstan analyse
vendor/bin/php-cs-fixer fix

# Database
php bin/console doctrine:schema:update --dump-sql
php bin/console doctrine:fixtures:load

# Cache
php bin/console cache:clear
php bin/console cache:warmup

# Debug
php bin/console debug:router
php bin/console debug:container
```

### Castor Tasks

```bash
# List all tasks
vendor/bin/castor

# Development tasks
vendor/bin/castor start
vendor/bin/castor db:reset
vendor/bin/castor cache
vendor/bin/castor logs
```

## Technology Stack

**Backend**
- Symfony 7.4 (PHP Framework)
- PHP 8.3 (Language)
- Doctrine ORM (Database)
- EasyAdmin 4 (Admin Generator)

**Frontend**
- Twig (Templates)
- Bootstrap 5 (CSS Framework)
- Chart.js (Charts)
- Vanilla JavaScript

**DevOps**
- Docker & Docker Compose
- Nginx (Web Server)
- MySQL 8 (Database)
- Castor (Task Runner)

## Project Architecture

The application follows **Symfony best practices** with:

- **MVC Architecture** - Model-View-Controller pattern
- **Service Layer** - Business logic separation
- **Repository Pattern** - Data access abstraction
- **Event-Driven** - Event listeners for cross-cutting concerns
- **Dependency Injection** - Service container

## File Structure

```
src/
├── Controller/           # HTTP Controllers
│   └── Admin/           # EasyAdmin CRUD controllers
├── Entity/              # Doctrine entities (domain models)
├── Repository/          # Database query logic
├── Service/             # Business logic services
├── EventListener/       # Event listeners
├── DataFixtures/        # Demo data fixtures
└── Kernel.php          # Application kernel

config/
├── packages/            # Bundle configurations
├── routes/             # Routing definitions
└── services.yaml       # Service container

templates/
├── admin/              # Admin panel templates
└── bundles/            # Bundle overrides

translations/
├── messages.fr.yaml    # French translations
├── messages.en.yaml    # English translations
└── messages.ar.yaml    # Arabic translations
```

## Next Steps

1. [Set up your development environment](setup.md)
2. [Understand the project structure](structure.md)
3. [Learn our coding standards](standards.md)
4. [Start contributing](contributing.md)

---

## Resources

- [Symfony Documentation](https://symfony.com/doc/current/index.html)
- [EasyAdmin Documentation](https://symfony.com/bundles/EasyAdminBundle/current/index.html)
- [Doctrine Documentation](https://www.doctrine-project.org/projects/doctrine-orm/en/latest/)
- [PHP Standards](https://www.php-fig.org/psr/)

---

**Ready to contribute?** Start with [Development Setup →](setup.md)
