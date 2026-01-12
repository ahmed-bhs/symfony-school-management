# Contributing to School Management System

First off, thank you for considering contributing to this educational project! 🎉

This document provides guidelines for contributing to the School Management System. Following these guidelines helps maintain code quality and makes the contribution process smooth for everyone.

## 📚 Table of Contents

- [Code of Conduct](#code-of-conduct)
- [How Can I Contribute?](#how-can-i-contribute)
- [Development Setup](#development-setup)
- [Coding Standards](#coding-standards)
- [Commit Guidelines](#commit-guidelines)
- [Pull Request Process](#pull-request-process)
- [Learning Resources](#learning-resources)

## Code of Conduct

This is an educational project designed to help students learn. Please be:
- **Respectful** of all contributors, regardless of experience level
- **Helpful** and patient with newcomers
- **Constructive** in your feedback
- **Inclusive** and welcoming to diverse perspectives

## How Can I Contribute?

### 🐛 Reporting Bugs

Before creating bug reports, please check existing issues. When creating a bug report, include:

- **Clear title and description**
- **Steps to reproduce** the problem
- **Expected behavior** vs **actual behavior**
- **Screenshots** if applicable
- **Environment details** (PHP version, Symfony version, OS)

**Example:**
```markdown
**Bug**: Students page shows wrong count

**Steps to reproduce**:
1. Go to /admin/etudiant
2. Look at the counter
3. Count actual students

**Expected**: Counter shows 50 students
**Actual**: Counter shows 45 students

**Environment**: PHP 8.3, Symfony 7.4, Docker
```

### ✨ Suggesting Enhancements

Enhancement suggestions are welcome! Please include:

- **Use case**: Why is this enhancement useful?
- **Proposed solution**: How would it work?
- **Alternatives considered**: What other approaches did you consider?

### 📝 Code Contributions

Great! Here are some ideas:

#### For Beginners
- Fix typos in documentation
- Add comments to existing code
- Improve error messages
- Add translations for new languages
- Write tests for existing features

#### For Intermediate Developers
- Add new CRUD features
- Improve UI/UX
- Add data validation
- Implement new reports
- Optimize database queries

#### For Advanced Developers
- Add API endpoints
- Implement authentication/authorization
- Add caching layer
- Performance optimization
- Integration with external services

## Development Setup

### Prerequisites

- Docker & Docker Compose
- Git
- Basic knowledge of PHP and Symfony

### Setting Up Your Development Environment

1. **Fork the repository** on GitHub

2. **Clone your fork**
   ```bash
   git clone https://github.com/YOUR_USERNAME/school-management-symfony.git
   cd school-management-symfony
   ```

3. **Add upstream remote**
   ```bash
   git remote add upstream https://github.com/ahmed-bhs/school-management-symfony.git
   ```

4. **Start the project**
   ```bash
   docker-compose up -d
   docker-compose exec php composer install
   docker-compose exec php php bin/console doctrine:database:create --if-not-exists
   docker-compose exec php php bin/console doctrine:migrations:migrate -n
   docker-compose exec php php bin/console doctrine:fixtures:load -n
   ```

5. **Create a new branch**
   ```bash
   git checkout -b feature/my-awesome-feature
   ```

### Keeping Your Fork Updated

```bash
git fetch upstream
git checkout main
git merge upstream/main
git push origin main
```

## Coding Standards

### PHP Code Style

We follow **PSR-12** coding standards. Please ensure your code adheres to these guidelines.

#### Key Points

- Use **4 spaces** for indentation (not tabs)
- Opening braces `{` go on the **same line** for classes and methods
- Use **camelCase** for variables and methods
- Use **PascalCase** for classes
- Add **type hints** for parameters and return types
- Write **meaningful** variable and function names

**Good Example:**
```php
<?php

namespace App\Controller\Admin;

use App\Entity\Student;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class StudentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Student::class;
    }

    private function calculateAverageGrade(Student $student): float
    {
        $grades = $student->getGrades();

        if (count($grades) === 0) {
            return 0.0;
        }

        $total = array_reduce(
            $grades,
            fn($sum, $grade) => $sum + $grade->getValue(),
            0
        );

        return $total / count($grades);
    }
}
```

**Bad Example:**
```php
<?php
// Missing namespace
// Missing type hints
// Poor variable names

class student_controller {
    function calc($s) {
        $g = $s->getGrades();
        $t = 0;
        foreach($g as $x) $t += $x->getValue();
        return $t / count($g);
    }
}
```

### Symfony Best Practices

- Use **dependency injection** instead of service locators
- Keep controllers **thin** - business logic belongs in services
- Use **repositories** for database queries
- Follow **naming conventions** for routes and templates
- Use **translation keys** instead of hard-coded text

**Good Example:**
```php
class StudentService
{
    public function __construct(
        private StudentRepository $repository,
        private LoggerInterface $logger
    ) {
    }

    public function enrollStudent(Student $student, Classe $class): void
    {
        $student->setClasse($class);
        $this->repository->save($student, true);

        $this->logger->info('Student enrolled', [
            'student_id' => $student->getId(),
            'class_id' => $class->getId(),
        ]);
    }
}
```

### Database Best Practices

- Always create **migrations** for schema changes
- Use **meaningful** migration names
- Add **indexes** for frequently queried fields
- Use **relationships** instead of manual joins
- Write **efficient queries** (avoid N+1 problems)

**Creating a Migration:**
```bash
# Make changes to your entities first
php bin/console make:migration

# Review the generated migration file
# Then run it
php bin/console doctrine:migrations:migrate
```

### Twig Templates

- Use **extends** and **blocks** for inheritance
- Keep logic out of templates (use controllers/services)
- Use **translation filters** for user-facing text
- Follow **naming conventions** (snake_case for files)

**Good Example:**
```twig
{% extends '@EasyAdmin/page/content.html.twig' %}

{% block page_title %}
    {{ 'entity.students'|trans }}
{% endblock %}

{% block main %}
    {% for student in students %}
        <div class="student-card">
            <h3>{{ student.fullName }}</h3>
            <p>{{ 'form.class'|trans }}: {{ student.classe.description }}</p>
        </div>
    {% endfor %}
{% endblock %}
```

## Commit Guidelines

We use **conventional commits** for clear and meaningful commit history.

### Commit Message Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting, semicolons, etc.)
- `refactor`: Code refactoring (no functionality change)
- `test`: Adding or updating tests
- `chore`: Maintenance tasks (dependencies, build, etc.)

### Examples

```bash
# Good commits
git commit -m "feat(students): add grade calculation service"
git commit -m "fix(dashboard): correct student count display"
git commit -m "docs(readme): add Docker setup instructions"
git commit -m "refactor(controllers): extract business logic to services"
git commit -m "style(entities): format code according to PSR-12"

# Bad commits
git commit -m "fixed stuff"
git commit -m "updates"
git commit -m "asdf"
git commit -m "WIP"
```

### Detailed Commit Example

```
feat(grades): add automatic grade calculation

- Implement GradeCalculatorService
- Add calculateAverage() method
- Include coefficient weighting
- Add unit tests

Closes #42
```

## Pull Request Process

### Before Submitting

1. **Test your changes**
   ```bash
   php bin/console cache:clear
   # Test manually in browser
   # Run any existing tests
   ```

2. **Format your code**
   ```bash
   # Use PHP CS Fixer (if installed)
   vendor/bin/php-cs-fixer fix src
   ```

3. **Update documentation** if needed

4. **Commit your changes** following commit guidelines

### Submitting a Pull Request

1. **Push to your fork**
   ```bash
   git push origin feature/my-awesome-feature
   ```

2. **Create Pull Request** on GitHub

3. **Fill out the PR template**
   - Describe what changes you made
   - Reference any related issues
   - Add screenshots if UI changes

### PR Template

```markdown
## Description
Brief description of what this PR does

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Documentation update
- [ ] Refactoring

## Related Issue
Closes #(issue number)

## Testing
How to test these changes:
1. Step 1
2. Step 2
3. Step 3

## Screenshots (if applicable)
[Add screenshots here]

## Checklist
- [ ] My code follows the project's coding standards
- [ ] I have tested my changes
- [ ] I have updated the documentation
- [ ] My commits follow the commit guidelines
```

### Review Process

- A maintainer will review your PR
- Be responsive to feedback
- Make requested changes
- Once approved, your PR will be merged!

## Translation Guidelines

When adding translatable text:

1. **Never hard-code** text in templates or controllers
2. Use **translation keys** in the messages domain
3. Add translations for **all three languages** (FR, EN, AR)

**Example:**

```yaml
# translations/messages.en.yaml
student:
  enrolled: 'Student enrolled successfully'
  not_found: 'Student not found'

# translations/messages.fr.yaml
student:
  enrolled: 'Étudiant inscrit avec succès'
  not_found: 'Étudiant non trouvé'

# translations/messages.ar.yaml
student:
  enrolled: 'تم تسجيل الطالب بنجاح'
  not_found: 'الطالب غير موجود'
```

## Testing Guidelines

### Manual Testing

Always test your changes by:

1. **Clearing cache**
2. **Testing in browser** at http://localhost:8080/admin
3. **Testing all affected pages**
4. **Testing in different languages**
5. **Testing edge cases**

### Writing Tests (Advanced)

If you're comfortable with testing:

```php
// tests/Service/GradeCalculatorTest.php
namespace App\Tests\Service;

use App\Service\GradeCalculator;
use PHPUnit\Framework\TestCase;

class GradeCalculatorTest extends TestCase
{
    public function testCalculateAverage(): void
    {
        $calculator = new GradeCalculator();
        $average = $calculator->calculateAverage([10, 15, 20]);

        $this->assertEquals(15, $average);
    }
}
```

## Learning Resources

### For Beginners

- [Symfony Documentation](https://symfony.com/doc/current/index.html)
- [PHP The Right Way](https://phptherightway.com/)
- [Git Tutorial](https://git-scm.com/book/en/v2)

### For Intermediate

- [SymfonyCasts](https://symfonycasts.com/) - Video tutorials
- [Doctrine Documentation](https://www.doctrine-project.org/projects/doctrine-orm/en/latest/)
- [PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/)

### For Advanced

- [Symfony Best Practices](https://symfony.com/doc/current/best_practices.html)
- [Design Patterns in PHP](https://refactoring.guru/design-patterns/php)
- [Clean Code Principles](https://github.com/jupeter/clean-code-php)

## Questions?

- Check [existing issues](https://github.com/ahmed-bhs/school-management-symfony/issues)
- Ask in [Symfony Slack](https://symfony.com/slack)
- Open a [new discussion](https://github.com/ahmed-bhs/school-management-symfony/discussions)

---

**Thank you for contributing! 🚀**

Every contribution, no matter how small, helps make this project better for learners worldwide.

*Happy Coding!* ❤️
