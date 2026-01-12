---
layout: default
title: Installation
parent: Getting Started
nav_order: 1
---

# Installation

Complete installation guide for the School Management System.

---

## Prerequisites

### Required Software

- **Docker** (version 20.10+) - Recommended
- **Docker Compose** (version 2.0+)
- **Git**

**OR** for local development:

- **PHP 8.3+**
- **Composer 2.x**
- **MySQL 8.0+**

---

## Option 1: Docker Installation (Recommended)

###  Step 1: Clone the Repository

```bash
git clone https://github.com/ahmed-bhs/symfony-school-management.git
cd symfony-school-management
```

### Step 2: Start Docker Containers

```bash
docker-compose up -d
```

This will start:
- PHP 8.3-FPM container
- Nginx web server
- MySQL 8 database
- PhpMyAdmin (optional)

### Step 3: Install Dependencies

```bash
docker-compose exec php composer install
```

### Step 4: Create Database

```bash
docker-compose exec php php bin/console doctrine:database:create --if-not-exists
```

### Step 5: Run Migrations

```bash
docker-compose exec php php bin/console doctrine:migrations:migrate -n
```

### Step 6: Load Demo Data (Optional)

```bash
docker-compose exec php php bin/console doctrine:fixtures:load -n
```

This will create sample data:
- 50 students
- 5 classes
- 10 professors
- Sessions and schedules
- Sample grades

### Step 7: Access the Application

- **Application**: [http://localhost:8080](http://localhost:8080)
- **Admin Panel**: [http://localhost:8080/admin](http://localhost:8080/admin)
- **PhpMyAdmin**: [http://localhost:8081](http://localhost:8081) (user: `root`, password: `root`)

---

## Option 2: Using Castor Task Runner

[Castor](https://github.com/jolicode/castor) is a modern task runner for PHP.

### Installation with Castor

```bash
# Build and start everything
vendor/bin/castor build

# Initialize database with fixtures
vendor/bin/castor db:init

# Access the app
# http://localhost:8080/admin
```

### Available Castor Commands

```bash
# List all commands
vendor/bin/castor

# Start/Stop
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

---

## Option 3: Local Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/ahmed-bhs/symfony-school-management.git
cd symfony-school-management
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Configure Environment

```bash
cp .env .env.local
```

Edit `.env.local` and configure your database:

```env
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/school_db?serverVersion=8.0"
```

### Step 4: Create Database

```bash
php bin/console doctrine:database:create
```

### Step 5: Run Migrations

```bash
php bin/console doctrine:migrations:migrate
```

### Step 6: Load Demo Data (Optional)

```bash
php bin/console doctrine:fixtures:load
```

### Step 7: Start Development Server

```bash
# Using Symfony CLI (recommended)
symfony server:start

# OR using PHP built-in server
php -S localhost:8000 -t public
```

### Step 8: Access the Application

- **Application**: [http://localhost:8000](http://localhost:8000)
- **Admin Panel**: [http://localhost:8000/admin](http://localhost:8000/admin)

---

## Verify Installation

### Check Application Status

```bash
# Verify Symfony requirements
php bin/console about

# Check database connection
php bin/console doctrine:schema:validate

# List all routes
php bin/console debug:router
```

### Expected Output

You should see:
- Symfony 7.4.x
- PHP 8.3.x
- Environment: dev
- Debug mode: enabled

---

## Troubleshooting

### Docker Issues

**Problem**: Port 8080 already in use

**Solution**: Stop other services or change port in `docker-compose.yml`:
```yaml
ports:
  - "8081:80"  # Change 8080 to 8081
```

**Problem**: Permission denied errors

**Solution**: Fix permissions:
```bash
sudo chown -R $USER:$USER .
chmod -R 755 var/ public/
```

### Database Issues

**Problem**: Cannot connect to database

**Solution**: Check `.env.local` configuration and ensure MySQL is running

**Problem**: Migration fails

**Solution**: Drop and recreate database:
```bash
php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### Composer Issues

**Problem**: Out of memory

**Solution**: Increase PHP memory limit:
```bash
php -d memory_limit=-1 /usr/local/bin/composer install
```

---

## Next Steps

After successful installation:

1. [Quick Start Guide](quick-start.md) - Learn basic usage
2. [Configuration](configuration.md) - Configure the system
3. [User Guide](../user-guide/index.md) - Learn all features

---

## Development Setup

For development, you might want to:

### Install Development Tools

```bash
composer require --dev symfony/debug-bundle
composer require --dev symfony/web-profiler-bundle
composer require --dev symfony/maker-bundle
```

### Enable Debug Mode

Ensure `.env.local` has:
```env
APP_ENV=dev
APP_DEBUG=1
```

### Access Symfony Profiler

After installation, the Symfony profiler toolbar will be available at the bottom of pages when `APP_DEBUG=1`.

---

## Production Setup

For production deployment:

### Step 1: Optimize Autoloader

```bash
composer install --no-dev --optimize-autoloader
```

### Step 2: Set Production Environment

```env
APP_ENV=prod
APP_DEBUG=0
```

### Step 3: Clear and Warm Cache

```bash
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod
```

### Step 4: Configure Web Server

Use Nginx or Apache with proper PHP-FPM configuration.

[See deployment documentation →](../development/deployment.md)

---

## Uninstallation

To completely remove the application:

### With Docker

```bash
docker-compose down -v  # Remove containers and volumes
rm -rf symfony-school-management
```

### Local Installation

```bash
php bin/console doctrine:database:drop --force
rm -rf symfony-school-management
```

---

**Installation complete!** 🎉

Continue to [Quick Start Guide](quick-start.md) to learn how to use the system.
