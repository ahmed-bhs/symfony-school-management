---
layout: home
title: Home
nav_order: 1
description: "Symfony 7.4 School Management System - Modern educational platform for managing students, classes, grades, and schedules"
permalink: /
---

# School Management System

**Symfony 7.4 + EasyAdmin 4 + PHP 8.3**

A modern school management system built with Symfony 7.4 and EasyAdmin 4. Perfect for learning modern PHP development, Symfony framework, and building real-world applications.

[![Symfony 7.4](https://img.shields.io/badge/Symfony-7.4-black.svg)](https://symfony.com)
[![PHP 8.3](https://img.shields.io/badge/PHP-8.3-777BB4.svg)](https://www.php.net)
[![EasyAdmin 4](https://img.shields.io/badge/EasyAdmin-4-blue.svg)](https://github.com/EasyCorp/EasyAdminBundle)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

---

## Educational Project

This is an **educational project** designed for students learning:
- Modern PHP development (PHP 8.3+)
- Symfony framework (version 7.4)
- Database design and Doctrine ORM
- Admin panel development with EasyAdmin
- Multi-language applications (i18n)
- Docker containerization

## Key Features

- **Student Management** - Complete profiles, class assignments, attendance
- **Class Management** - Class organization, enrollment, scheduling
- **Professor Management** - Profiles, session assignments, evaluations
- **Session Management** - Weekly schedules, time slots
- **Grades & Evaluations** - Grade recording, calculations, tracking
- **Dashboard & Statistics** - Real-time stats, charts, performance tracking
- **Multi-language** - French, English, Arabic with RTL support
- **Modern UI** - Professional responsive design with Bootstrap 5

## Quick Start

```bash
# Clone the repository
git clone https://github.com/ahmed-bhs/symfony-school-management.git
cd symfony-school-management

# Start with Docker
docker-compose up -d

# Install dependencies
docker-compose exec php composer install

# Setup database
docker-compose exec php php bin/console doctrine:database:create
docker-compose exec php php bin/console doctrine:migrations:migrate
docker-compose exec php php bin/console doctrine:fixtures:load

# Access the application
# http://localhost:8080/admin
```

[Full installation guide →](getting-started/installation.md)

---

## Documentation Structure

| Section | Description |
|---------|-------------|
| [**Getting Started**](getting-started/index.md) | Installation, quick start, first steps |
| [**User Guide**](user-guide/index.md) | How to use the system features |
| [**Architecture**](architecture/index.md) | Project structure and design decisions |
| [**Database**](database/index.md) | Entity relationships and schema |
| [**Development**](development/index.md) | Development workflow and best practices |
| [**Migration Guide**](migration/index.md) | From Symfony 3.1 to 7.4 |

---

## Technology Stack

**Backend**
- Symfony 7.4 - PHP framework
- PHP 8.3 - Programming language
- Doctrine ORM - Database abstraction
- EasyAdmin 4 - Admin panel generator
- MySQL 8 - Database

**Frontend**
- Twig - Template engine
- Bootstrap 5 - UI framework
- Chart.js - Data visualization
- Custom CSS - Professional theming

**DevOps**
- Docker & Docker Compose - Containerization
- Castor - Task runner
- PHP-FPM & Nginx - Web server

---

## Project History

This project started as a **Symfony 3.1 application** in 2017 and was completely migrated to Symfony 7.4 in 2026.

### Migration Journey

- Symfony 3.1 → 7.4 (8-year jump!)
- PHP 5.6 → 8.3
- Doctrine 2.5 → 3.x
- Replaced custom admin with EasyAdmin 4
- Added multi-language support (FR, EN, AR)
- Modernized with Docker and Castor
- Complete UI/UX overhaul

[Read the full migration story →](migration/index.md)

---

## Support This Project

If this project helped you learn Symfony or saved you time, consider buying me a coffee!

[![Buy Me A Coffee](https://img.shields.io/badge/Buy%20Me%20A%20Coffee-Support-FFDD00?style=for-the-badge&logo=buy-me-a-coffee&logoColor=black)](https://buymeacoffee.com/w6ZhBSGX2)

---

## Requirements

- PHP 8.3+
- Symfony 7.4
- MySQL 8.0+
- Docker & Docker Compose (recommended)
- Composer 2.x

---

## Contributing

Contributions are welcome! Whether you're fixing bugs, adding features, or improving documentation, your help is appreciated.

[Contributing Guidelines →](contributing.md)

---

## License

MIT License - see [LICENSE](https://github.com/ahmed-bhs/symfony-school-management/blob/main/LICENSE) for details.

---

**Made with ❤️ for learning PHP and Symfony**

*Happy Coding! 🚀*
