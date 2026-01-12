# 🎓 School Management System - Symfony 7.4 + EasyAdmin

[![Symfony 7.4](https://img.shields.io/badge/Symfony-7.4-black.svg?style=flat-square&logo=symfony)](https://symfony.com)
[![PHP 8.3](https://img.shields.io/badge/PHP-8.3-777BB4.svg?style=flat-square&logo=php)](https://www.php.net)
[![EasyAdmin 4](https://img.shields.io/badge/EasyAdmin-4-blue.svg?style=flat-square)](https://github.com/EasyCorp/EasyAdminBundle)
[![License](https://img.shields.io/badge/license-MIT-green.svg?style=flat-square)](LICENSE)

<div align="center">

### ☕ Support This Project

If this project helped you learn Symfony or saved you time, consider buying me a coffee!

[![Buy Me A Coffee](https://img.shields.io/badge/Buy%20Me%20A%20Coffee-Support-FFDD00?style=for-the-badge&logo=buy-me-a-coffee&logoColor=black)](https://buymeacoffee.com/w6ZhBSGX2)

*Your support helps maintain this educational project and create more learning resources!* ❤️

</div>

> **📚 Educational Project** - A modern school management system built with Symfony 7.4 and EasyAdmin 4. Perfect for learning PHP, Symfony framework, and modern web development practices.

This project is a **complete modernization** of an [8-year-old Symfony 3.1 application](https://github.com/ahmed-bhs/old-school-project), migrated to Symfony 7.4 with best practices and modern architecture.

---

## 📖 Table of Contents

- [About](#-about)
- [Screenshots](#-screenshots)
- [Features](#-features)
- [Technology Stack](#-technology-stack)
- [Prerequisites](#-prerequisites)
- [Installation](#-installation)
- [Usage](#-usage)
- [Learning Objectives](#-learning-objectives)
- [Migration History](#-migration-history)
- [Contributing](#-contributing)
- [License](#-license)

---

## 🎯 About

This School Management System is designed as an **educational project** for students learning:
- ✅ Modern PHP development (PHP 8.3+)
- ✅ Symfony framework (version 7.4)
- ✅ Database design and Doctrine ORM
- ✅ Admin panel development with EasyAdmin
- ✅ Multi-language applications (i18n)
- ✅ Docker containerization
- ✅ Modern web development practices

### What Makes This Project Special?

✅ **Real-world application** - Not just a tutorial, but a functional school management system
✅ **Modern architecture** - Follows Symfony 7.4 best practices
✅ **Multilingual** - Full support for French, English, and Arabic
✅ **Professional UI** - Clean, modern interface with custom themes
✅ **Well-documented** - Comprehensive documentation and comments
✅ **Docker-ready** - Easy setup with Docker containers
✅ **Migration example** - Learn how to migrate legacy applications

---

## 📸 Screenshots

<div align="center">

### 🎨 Modern & Professional Interface

<table>
<tr>
<td width="50%">

#### 📊 Dashboard
Professional dashboard with real-time statistics, charts, and performance tracking.

<img src="public/images/screenshots/01-dashboard.png" alt="Dashboard" width="100%" />

</td>
<td width="50%">

#### 📚 Class Selection
Elegant class selection interface with colorful cards and student counts.

<img src="public/images/screenshots/02-class-selection.png" alt="Class Selection" width="100%" />

</td>
</tr>
</table>

### ✨ Mass Grade Entry System

<table>
<tr>
<td width="33%">

#### 📋 Evaluation Selection
Choose evaluation with detailed information cards.

<img src="public/images/screenshots/03-evaluation-selection.png" alt="Evaluation Selection" width="100%" />

</td>
<td width="33%">

#### ✏️ Grade Entry
Bulk grade entry with real-time statistics and keyboard navigation.

<img src="public/images/screenshots/04-grade-entry.png" alt="Grade Entry" width="100%" />

</td>
<td width="33%">

#### 👥 Student List
Comprehensive student management with filtering and search.

<img src="public/images/screenshots/05-student-list.png" alt="Student List" width="100%" />

</td>
</tr>
</table>

**✨ Key UI Features:**
- 🎨 Modern gradient designs
- 📊 Real-time statistics updates
- ⌨️ Advanced keyboard navigation (Enter/↑/↓)
- 🌍 Multi-language support (FR/EN/AR)
- 📱 Fully responsive design
- 🎯 Professional animations & transitions

</div>

---

## ✨ Features

### Core Functionality

- **👥 Student Management**
  - Complete student profiles (name, birth date, address, parents info)
  - Class assignment
  - Attendance tracking
  - Grade management

- **📚 Class Management**
  - Class organization by year
  - Student enrollment
  - Session scheduling

- **👨‍🏫 Professor Management**
  - Professor profiles with skills and competencies
  - Session assignments
  - Evaluation creation

- **📅 Session Management**
  - Weekly schedule management
  - Class and professor assignments
  - Time slot organization

- **📝 Evaluation & Grades**
  - Create evaluations with coefficients
  - Record student grades
  - Automatic grade calculations
  - Performance tracking

- **📊 Dashboard & Statistics**
  - Real-time statistics
  - Student performance charts
  - Absence tracking
  - Top performers display

### Technical Features

- **🌍 Internationalization (i18n)**
  - French (Français)
  - English
  - Arabic (العربية) with RTL support

- **🎨 Modern UI/UX**
  - Professional theme
  - Responsive design
  - Interactive charts and graphs
  - Full-width datatables
  - Smooth animations

---

## 🛠 Technology Stack

### Backend
- **Symfony 7.4** - PHP framework
- **PHP 8.3** - Programming language
- **Doctrine ORM** - Database abstraction
- **EasyAdmin 4** - Admin panel generator
- **MySQL 8** - Database

### Frontend
- **Twig** - Template engine
- **Bootstrap 5** - UI framework
- **Chart.js** - Data visualization
- **Custom CSS** - Professional theming

### DevOps
- **Docker & Docker Compose** - Containerization
- **Castor** - Task runner (modern alternative to Makefile)
- **PHP-FPM & Nginx** - Web server

---

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- **Docker** (version 20.10 or higher)
- **Docker Compose** (version 2.0 or higher)
- **Git**

**OR** if you prefer local development:

- **PHP 8.3 or higher**
- **Composer 2.x**
- **MySQL 8.0 or higher**

---

## 🚀 Installation

### Option 1: Docker Installation (Recommended)

1. **Clone the repository**
   ```bash
   git clone https://github.com/YOUR_USERNAME/school-management-symfony.git
   cd school-management-symfony
   ```

2. **Start Docker containers**
   ```bash
   docker-compose up -d
   ```

3. **Install dependencies**
   ```bash
   docker-compose exec php composer install
   ```

4. **Create database and run migrations**
   ```bash
   docker-compose exec php php bin/console doctrine:database:create --if-not-exists
   docker-compose exec php php bin/console doctrine:migrations:migrate -n
   ```

5. **Load demo data (optional)**
   ```bash
   docker-compose exec php php bin/console doctrine:fixtures:load -n
   ```

6. **Access the application**
   - Application: http://localhost:8080
   - Admin panel: http://localhost:8080/admin
   - PhpMyAdmin: http://localhost:8081 (user: `root`, password: `root`)

### Option 2: Using Castor (Task Runner)

```bash
# Build and start everything
vendor/bin/castor build

# Initialize database with fixtures
vendor/bin/castor db:init

# Access the app at http://localhost:8080/admin
```

### Option 3: Local Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/YOUR_USERNAME/school-management-symfony.git
   cd school-management-symfony
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure environment**
   ```bash
   cp .env .env.local
   ```

   Edit `.env.local` and configure your database:
   ```env
   DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/school_db?serverVersion=8.0"
   ```

4. **Create database and run migrations**
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. **Load demo data (optional)**
   ```bash
   php bin/console doctrine:fixtures:load
   ```

6. **Start development server**
   ```bash
   symfony server:start
   # OR
   php -S localhost:8000 -t public
   ```

---

## 📖 Usage

### Quick Start

After installation, you can:

1. **Access the admin panel** at `/admin`
2. **Switch languages** using the language selector (top-right corner)
3. **Browse entities**: Students, Classes, Professors, Sessions, Evaluations, Grades, Absences

### Common Commands

#### Using Castor (Recommended)

```bash
# List all available commands
vendor/bin/castor

# Start/stop project
vendor/bin/castor start
vendor/bin/castor stop
vendor/bin/castor restart

# Database operations
vendor/bin/castor db:init      # Create database and load fixtures
vendor/bin/castor db:migrate   # Run migrations
vendor/bin/castor db:reset     # Reset database

# Utilities
vendor/bin/castor cache        # Clear cache
vendor/bin/castor logs         # View logs
vendor/bin/castor shell        # Access PHP container shell
vendor/bin/castor routes       # List all routes
```

#### Using Symfony Console

```bash
# Clear cache
php bin/console cache:clear

# Run migrations
php bin/console doctrine:migrations:migrate

# Load fixtures (demo data)
php bin/console doctrine:fixtures:load

# Debug routes
php bin/console debug:router

# Check translations
php bin/console debug:translation fr
```

---

## 🎓 Learning Objectives

This project is designed to help students learn:

### Symfony Framework
- ✅ **MVC Architecture** - Model-View-Controller pattern
- ✅ **Routing** - URL routing and controllers
- ✅ **Doctrine ORM** - Database interactions and relationships
- ✅ **Twig Templates** - Template engine
- ✅ **Dependency Injection** - Service container
- ✅ **Event System** - Event listeners and subscribers
- ✅ **Forms** - Form handling and validation
- ✅ **Security** - Authentication and authorization

### EasyAdmin Bundle
- ✅ **CRUD Generation** - Automatic admin panels
- ✅ **Field Configuration** - Custom field types
- ✅ **Actions** - Custom actions and batch operations
- ✅ **Filters** - Data filtering and search
- ✅ **Dashboard** - Custom dashboard creation

### Database Design
- ✅ **Entity Relationships** - OneToMany, ManyToOne, ManyToMany
- ✅ **Migrations** - Database versioning
- ✅ **Fixtures** - Sample data generation
- ✅ **Repositories** - Custom queries and DQL

### Internationalization
- ✅ **Translation System** - Multi-language support
- ✅ **Locale Handling** - Language switching
- ✅ **RTL Support** - Right-to-left languages (Arabic)
- ✅ **Domain Separation** - Technical vs business translations

### Modern PHP
- ✅ **PHP 8.3 Features** - Attributes, typed properties, constructor promotion
- ✅ **Namespaces** - Code organization
- ✅ **PSR Standards** - Coding standards
- ✅ **Composer** - Dependency management

### DevOps
- ✅ **Docker** - Containerization with Docker Compose
- ✅ **Environment Configuration** - .env files
- ✅ **Version Control** - Git best practices
- ✅ **Task Automation** - Castor task runner

---

## 📜 Migration History

### From Symfony 3.1 to 7.4

This project started as a **Symfony 3.1 application** created over **8 years ago** (2017). The original project can be found here: [old-school-project (Symfony 3.1)](https://github.com/ahmed-bhs/old-school-project)

#### Key Migration Changes

**Framework Updates**
- ✅ Symfony 3.1 → 7.4 (major version jump)
- ✅ PHP 5.6 → 8.3
- ✅ Doctrine 2.5 → 3.x
- ✅ Twig 2.x → 3.x

**Architecture Modernization**
- ✅ Replaced old `AppBundle` with modern `App` namespace
- ✅ Migrated from annotations to PHP 8 attributes
- ✅ Updated service configuration to autowiring
- ✅ Modernized controller structure
- ✅ Removed deprecated code and bundles

**UI/UX Improvements**
- ✅ Replaced custom admin with EasyAdmin 4
- ✅ Custom professional theme
- ✅ Responsive design
- ✅ Modern JavaScript interactions
- ✅ Chart.js integration for statistics

**New Features**
- ✅ Multi-language support (FR, EN, AR)
- ✅ RTL support for Arabic
- ✅ Enhanced statistics dashboard
- ✅ Docker containerization
- ✅ Comprehensive fixtures for demo data
- ✅ Full-width datatables
- ✅ Improved UX with 12 items per page

**Developer Experience**
- ✅ Docker Compose setup
- ✅ Castor task runner
- ✅ Improved documentation
- ✅ Translation best practices guide
- ✅ Migration documentation

#### Migration Documentation

Detailed migration documentation can be found in:
- `MIGRATION_COMPLETE.md` - Complete migration guide
- `TRANSLATION_BEST_PRACTICES.md` - i18n implementation guide
- `STATUS.md` - Project status and next steps

---

## 📁 Project Structure

```
school-management-symfony/
├── config/                 # Configuration files
│   ├── packages/          # Bundle configurations
│   └── routes/            # Routing definitions
├── migrations/            # Database migrations
├── public/                # Web accessible files
│   ├── css/              # Custom stylesheets
│   └── js/               # JavaScript files
├── src/
│   ├── Controller/       # Controllers
│   │   └── Admin/        # EasyAdmin CRUD controllers
│   ├── Entity/           # Doctrine entities
│   ├── EventListener/    # Event listeners
│   ├── Repository/       # Database repositories
│   ├── DataFixtures/     # Demo data fixtures
│   └── Service/          # Business logic services
├── templates/            # Twig templates
│   ├── admin/           # Admin templates
│   └── bundles/         # Bundle overrides
├── translations/        # Translation files (i18n)
│   ├── messages.fr.yaml
│   ├── messages.en.yaml
│   ├── messages.ar.yaml
│   ├── EasyAdminBundle.fr.yaml
│   ├── EasyAdminBundle.en.yaml
│   └── EasyAdminBundle.ar.yaml
├── docker/              # Docker configuration
├── .env                 # Environment template
├── composer.json       # PHP dependencies
├── docker-compose.yml  # Docker services
├── castor.php          # Castor tasks
└── README.md          # This file
```

---

## 🤝 Contributing

This is an educational project and contributions are welcome! Here's how you can help:

### For Students

1. **Fork the project**
2. **Create a feature branch** (`git checkout -b feature/AmazingFeature`)
3. **Make your changes**
4. **Commit your changes** (`git commit -m 'Add some AmazingFeature'`)
5. **Push to the branch** (`git push origin feature/AmazingFeature`)
6. **Open a Pull Request**

### Ideas for Contributions

- 🐛 Fix bugs
- ✨ Add new features (attendance reports, grade export, etc.)
- 📝 Improve documentation
- 🌍 Add more language translations (Spanish, German, etc.)
- 🎨 Enhance UI/UX
- ✅ Write tests
- 📊 Add more statistics/charts
- 🔐 Improve security features
- 📱 Mobile responsiveness improvements

### Code Style

- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Add PHPDoc comments for complex logic
- Keep functions small and focused
- Write clean, readable code

See `CONTRIBUTING.md` for detailed guidelines.

---

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👨‍💻 Authors

- **Ahmed Ben Hassine** - *Initial work (Symfony 3.1, 2017)* - [GitHub](https://github.com/ahmed-bhs)
- **Ahmed Ben Hassine** - *Migration to Symfony 7.4 (2026)* - [GitHub](https://github.com/ahmed-bhs)

---

## 🙏 Acknowledgments

- Original project: [old-school-project](https://github.com/ahmed-bhs/old-school-project) (Symfony 3.1, 2017)
- [Symfony](https://symfony.com) - The PHP framework
- [EasyAdmin](https://github.com/EasyCorp/EasyAdminBundle) - Admin generator
- [Doctrine](https://www.doctrine-project.org/) - ORM
- All contributors and students learning from this project

---

## 📚 Resources for Learning

### Official Documentation
- [Symfony Documentation](https://symfony.com/doc/current/index.html)
- [EasyAdmin Documentation](https://symfony.com/bundles/EasyAdminBundle/current/index.html)
- [Doctrine Documentation](https://www.doctrine-project.org/projects/doctrine-orm/en/latest/)
- [Twig Documentation](https://twig.symfony.com/doc/3.x/)

### Tutorials
- [Symfony Casts](https://symfonycasts.com/) - Video tutorials
- [SymfonyLab](https://www.symfonylab.fr/) - French tutorials
- [OpenClassrooms Symfony Course](https://openclassrooms.com/fr/courses/5489656-construisez-un-site-web-a-l-aide-du-framework-symfony)

### Community
- [Symfony Slack](https://symfony.com/slack)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/symfony)
- [Reddit r/symfony](https://www.reddit.com/r/symfony/)

---

## 🆘 Support

If you have questions or need help:

1. Check the [documentation](docs/)
2. Search [existing issues](https://github.com/YOUR_USERNAME/school-management-symfony/issues)
3. Create a [new issue](https://github.com/YOUR_USERNAME/school-management-symfony/issues/new)
4. Ask in [Symfony Slack](https://symfony.com/slack)

---

## 🗺 Roadmap

Future improvements planned:

- [ ] Add user authentication system
- [ ] Implement role-based permissions (RBAC)
- [ ] Add PDF report generation (student cards, grade reports)
- [ ] Email notifications (absences, grades)
- [ ] API endpoints (REST/GraphQL)
- [ ] Unit and functional tests
- [ ] Performance optimization
- [ ] Import/Export features (CSV, Excel)
- [ ] Attendance QR code scanning
- [ ] Parent portal
- [ ] SMS notifications

---

**Made with ❤️ for learning PHP and Symfony**

*Happy Coding! 🚀*
