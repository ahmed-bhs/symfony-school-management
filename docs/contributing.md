---
layout: default
title: Contributing
nav_order: 8
---

# Contributing to School Management System

Thank you for your interest in contributing! This guide will help you get started.

---

## Ways to Contribute

There are many ways to contribute to this project:

- Report bugs
- Suggest new features
- Improve documentation
- Submit code fixes
- Add translations
- Write tests
- Share your experience

---

## Getting Started

### 1. Fork the Repository

Click the "Fork" button on GitHub to create your own copy:

[Fork on GitHub](https://github.com/ahmed-bhs/symfony-school-management/fork)

### 2. Clone Your Fork

```bash
git clone https://github.com/YOUR_USERNAME/symfony-school-management.git
cd symfony-school-management
```

### 3. Set Up Development Environment

Follow the [Development Setup Guide](development/index.md) to configure your local environment.

### 4. Create a Branch

```bash
git checkout -b feature/your-feature-name
```

Use descriptive branch names:
- `feature/add-email-notifications`
- `fix/grade-calculation-bug`
- `docs/improve-installation-guide`

---

## Making Changes

### Code Style

Follow PSR-12 coding standards:

```bash
# Check code style
vendor/bin/php-cs-fixer fix --dry-run

# Fix code style automatically
vendor/bin/php-cs-fixer fix
```

### Commit Messages

Write clear, descriptive commit messages:

**Good:**
```
fix: correct grade calculation for weighted averages

- Add coefficient multiplier to grade calculations
- Update tests to verify weighted average logic
- Fixes #123
```

**Bad:**
```
fixed stuff
```

### Commit Message Format

```
<type>: <subject>

<body>

<footer>
```

**Types:**
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting)
- `refactor`: Code refactoring
- `test`: Adding tests
- `chore`: Maintenance tasks

---

## Testing

### Run Tests

```bash
# Run all tests
vendor/bin/phpunit

# Run specific test
vendor/bin/phpunit tests/Entity/EtudiantTest.php

# With coverage
XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-html coverage
```

### Write Tests

Add tests for new features:

```php
<?php

namespace App\Tests\Entity;

use App\Entity\Etudiant;
use PHPUnit\Framework\TestCase;

class EtudiantTest extends TestCase
{
    public function testGetFullName(): void
    {
        $etudiant = new Etudiant();
        $etudiant->setNom('Doe');
        $etudiant->setPrenom('John');

        $this->assertEquals('John Doe', $etudiant->getFullName());
    }
}
```

---

## Pull Request Process

### 1. Push Your Changes

```bash
git add .
git commit -m "feat: add email notification feature"
git push origin feature/your-feature-name
```

### 2. Create Pull Request

1. Go to your fork on GitHub
2. Click "New Pull Request"
3. Select your branch
4. Fill in the PR template

### 3. PR Template

```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Documentation update
- [ ] Code refactoring

## Checklist
- [ ] Code follows PSR-12 standards
- [ ] Tests pass
- [ ] Documentation updated
- [ ] Commit messages are clear

## Screenshots (if applicable)
Add screenshots here

## Related Issues
Fixes #123
```

### 4. Code Review

- Respond to feedback promptly
- Make requested changes
- Push updates to your branch

### 5. Merge

Once approved, your PR will be merged!

---

## Bug Reports

### Before Submitting

1. Check existing issues
2. Verify bug exists in latest version
3. Collect error messages and logs

### Bug Report Template

```markdown
**Describe the bug**
A clear description of the bug.

**To Reproduce**
Steps to reproduce:
1. Go to '...'
2. Click on '...'
3. See error

**Expected behavior**
What you expected to happen.

**Screenshots**
If applicable, add screenshots.

**Environment:**
- OS: [e.g., Ubuntu 22.04]
- PHP Version: [e.g., 8.3]
- Symfony Version: [e.g., 7.4]
- Browser: [e.g., Chrome 120]

**Additional context**
Any other relevant information.
```

[Submit Bug Report](https://github.com/ahmed-bhs/symfony-school-management/issues/new)

---

## Feature Requests

### Feature Request Template

```markdown
**Is your feature request related to a problem?**
A clear description of the problem.

**Describe the solution**
What you want to happen.

**Describe alternatives**
Other solutions you've considered.

**Additional context**
Screenshots, mockups, examples.
```

[Submit Feature Request](https://github.com/ahmed-bhs/symfony-school-management/issues/new)

---

## Documentation

### Improving Documentation

Documentation is in `docs/` folder using Jekyll:

```bash
cd docs
bundle install
bundle exec jekyll serve
```

Visit http://localhost:4000/symfony-school-management/

### Documentation Style

- Use clear, simple language
- Include code examples
- Add screenshots when helpful
- Keep navigation logical

---

## Translation

### Adding a New Language

1. Create translation files:
   ```bash
   touch translations/messages.es.yaml
   touch translations/EasyAdminBundle.es.yaml
   ```

2. Translate strings:
   ```yaml
   # messages.es.yaml
   student: Estudiante
   class: Clase
   professor: Profesor
   ```

3. Test translations:
   ```bash
   php bin/console debug:translation es
   ```

[Translation Guide](getting-started/configuration.md#locale-and-language)

---

## Code of Conduct

### Our Pledge

We are committed to providing a welcoming and inspiring community for all.

### Our Standards

**Positive behavior:**
- Being respectful and inclusive
- Accepting constructive criticism
- Focusing on what's best for the community

**Unacceptable behavior:**
- Harassment or discriminatory language
- Trolling or insulting comments
- Publishing others' private information

### Enforcement

Report violations to: ahmed@example.com

---

## Development Guidelines

### PHP Standards

Follow PSR-12:
- 4 spaces for indentation
- Opening braces on same line for methods
- Type declarations for all properties
- Return type declarations

### Symfony Best Practices

- Use dependency injection
- Follow naming conventions
- Use service autowiring
- Write clear documentation

### Database Changes

Always use migrations:

```bash
# Create migration
php bin/console make:migration

# Review migration file
# Then apply
php bin/console doctrine:migrations:migrate
```

### Security

- Never commit credentials
- Sanitize user input
- Use prepared statements
- Follow OWASP guidelines

---

## Getting Help

Need help contributing?

- Ask in [Discussions](https://github.com/ahmed-bhs/symfony-school-management/discussions)
- Join [Symfony Slack](https://symfony.com/slack)
- Read [Symfony Docs](https://symfony.com/doc/current/index.html)
- Check [EasyAdmin Docs](https://symfony.com/bundles/EasyAdminBundle/current/index.html)

---

## Recognition

Contributors will be:

- Listed in CONTRIBUTORS.md
- Mentioned in release notes
- Credited in documentation

---

## License

By contributing, you agree that your contributions will be licensed under the MIT License.

---

## Questions?

Open an issue or discussion on GitHub. We're here to help!

**Thank you for contributing!** 🎉

---

## Useful Links

- [GitHub Repository](https://github.com/ahmed-bhs/symfony-school-management)
- [Documentation](https://ahmed-bhs.github.io/symfony-school-management/)
- [Issue Tracker](https://github.com/ahmed-bhs/symfony-school-management/issues)
- [Pull Requests](https://github.com/ahmed-bhs/symfony-school-management/pulls)
