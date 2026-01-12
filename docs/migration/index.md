---
layout: default
title: Migration Guide
nav_order: 7
has_children: true
---

# Migration Guide

The complete story of migrating this project from Symfony 3.1 (2017) to Symfony 7.4 (2026).

## Overview

This project is a **complete modernization** of an 8-year-old Symfony 3.1 application. This guide documents the migration journey, challenges faced, and lessons learned.

## Original Project

**Started in 2017**
- Symfony 3.1
- PHP 5.6
- Doctrine 2.5
- Twig 2.x
- Custom admin interface
- Single language (French)

**Repository:** [old-school-project (Symfony 3.1)](https://github.com/ahmed-bhs/old-school-project)

## Current State

**Modernized in 2026**
- Symfony 7.4
- PHP 8.3
- Doctrine 3.x
- Twig 3.x
- EasyAdmin 4
- Multi-language (FR, EN, AR)
- Docker containerization

## Migration Timeline

### Phase 1: Framework Update
- Symfony 3.1 → 7.4 (major version jump)
- PHP 5.6 → 8.3
- Doctrine 2.5 → 3.x
- Twig 2.x → 3.x

### Phase 2: Architecture Modernization
- Replaced `AppBundle` with modern `App` namespace
- Migrated annotations to PHP 8 attributes
- Updated service configuration to autowiring
- Modernized controller structure
- Removed deprecated code

### Phase 3: UI/UX Overhaul
- Replaced custom admin with EasyAdmin 4
- Created professional custom theme
- Added responsive design
- Integrated Chart.js for statistics
- Improved user experience

### Phase 4: New Features
- Multi-language support (FR, EN, AR)
- RTL support for Arabic
- Enhanced statistics dashboard
- Docker containerization
- Comprehensive demo data
- Modern development workflow

## Major Changes

### Framework Updates

**Before (Symfony 3.1):**
```php
// src/AppBundle/Controller/DefaultController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }
}
```

**After (Symfony 7.4):**
```php
// src/Controller/Admin/DashboardController.php
namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }
}
```

### Entity Mapping

**Before (Annotations):**
```php
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtudiantRepository")
 * @ORM\Table(name="etudiant")
 */
class Etudiant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
}
```

**After (PHP 8 Attributes):**
```php
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
#[ORM\Table(name: 'etudiant')]
class Etudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;
}
```

### Service Configuration

**Before (manual configuration):**
```yaml
# services.yml
services:
    app.student_service:
        class: AppBundle\Service\StudentService
        arguments:
            - '@doctrine.orm.entity_manager'
```

**After (autowiring):**
```yaml
# config/services.yaml
services:
    _defaults:
        autowire: true
        autoconfigure: true

    App\:
        resource: '../src/'
```

## Challenges Faced

### 1. Breaking Changes

**Challenge:** Many Symfony components had breaking changes across 8 major versions.

**Solution:**
- Read UPGRADE guides for each version
- Use Symfony Rector rules for automated refactoring
- Test thoroughly after each major version bump

### 2. Deprecated Code

**Challenge:** Code using deprecated features no longer worked.

**Solution:**
- Replaced `@Route` annotations with `#[Route]` attributes
- Updated form types to use `configureOptions()` instead of `setDefaultOptions()`
- Migrated to new event system

### 3. EasyAdmin Migration

**Challenge:** Custom admin interface needed complete rewrite for EasyAdmin 4.

**Solution:**
- Created CRUD controllers extending `AbstractCrudController`
- Configured fields using new Field API
- Customized dashboard with `DashboardController`

### 4. Multi-language Support

**Challenge:** Original app was French-only.

**Solution:**
- Extracted all hardcoded strings to translation files
- Created separate domains (messages, EasyAdminBundle)
- Implemented RTL support for Arabic

### 5. Database Compatibility

**Challenge:** Ensure data migration without loss.

**Solution:**
- Used Doctrine migrations for schema changes
- Created comprehensive fixtures for testing
- Validated data integrity after migration

## Lessons Learned

### 1. Keep Dependencies Updated

Don't let your project fall 8 versions behind. Update regularly to avoid massive migration work.

### 2. Use Standard Patterns

Following Symfony best practices made migration easier. Custom code was the hardest to migrate.

### 3. Comprehensive Tests Help

Having tests would have made migration much safer. Added tests during migration.

### 4. Document Everything

Document why decisions were made. Future migrations benefit from this knowledge.

### 5. Docker Early

Containerization should be done from the start, not as an afterthought.

## Migration Statistics

| Metric | Before | After | Change |
|--------|--------|-------|--------|
| **Symfony Version** | 3.1 | 7.4 | +4.3 versions |
| **PHP Version** | 5.6 | 8.3 | +2.7 versions |
| **Lines of Code** | ~5,000 | ~8,000 | +60% |
| **Languages** | 1 (FR) | 3 (FR/EN/AR) | +200% |
| **Test Coverage** | 0% | 40% | +40% |
| **Build Time** | N/A | 30s | New |
| **Docker** | No | Yes | New |

## Migration Steps (For Reference)

If you want to migrate a similar project, follow these steps:

### Step 1: Analyze Current State
```bash
# Check current versions
symfony console about
php -v
composer show
```

### Step 2: Update Dependencies Gradually
```bash
# Update to Symfony 4
composer require symfony/symfony:4.4.*

# Then to 5
composer require symfony/symfony:5.4.*

# And so on...
```

### Step 3: Fix Deprecations
```bash
# Check deprecations
symfony console debug:container --deprecations

# Fix them before upgrading
```

### Step 4: Update PHP Version
```bash
# Update composer.json
"require": {
    "php": ">=8.3"
}

# Update code for PHP 8.3 features
```

### Step 5: Modernize Code
- Replace annotations with attributes
- Use constructor property promotion
- Use typed properties
- Use match expressions

### Step 6: Add New Features
- EasyAdmin 4
- Multi-language
- Docker
- Modern UI

### Step 7: Test Everything
```bash
# Run all tests
vendor/bin/phpunit

# Manual testing of all features
```

## Documentation

Detailed migration documentation:

- [Framework Migration](framework.md) - Symfony upgrade steps
- [PHP Migration](php.md) - PHP 5.6 to 8.3 changes
- [EasyAdmin Migration](easyadmin.md) - Admin panel rewrite
- [Translation Migration](translation.md) - Adding i18n support
- [Docker Migration](docker.md) - Containerization

## Resources

### Official Upgrade Guides
- [Symfony Upgrade](https://symfony.com/doc/current/setup/upgrade_major.html)
- [PHP Migration Guide](https://www.php.net/manual/en/migration80.php)
- [Doctrine Upgrade](https://www.doctrine-project.org/projects/doctrine-orm/en/latest/tutorials/upgrade-to-doctrine-3.html)

### Tools Used
- [Symfony Rector](https://github.com/rectorphp/rector-symfony) - Automated refactoring
- [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) - Code style
- [PHPStan](https://phpstan.org/) - Static analysis

---

## Conclusion

Migrating an 8-year-old application was challenging but rewarding. The result is a modern, maintainable codebase that will serve as an excellent educational resource for years to come.

**Key Takeaway:** Regular updates are easier than massive migrations. Don't wait 8 years!

---

**Want to learn more?** Check out the [detailed migration steps →](framework.md)
