---
layout: default
title: Configuration
parent: Getting Started
nav_order: 3
---

# Configuration

Configure the School Management System for your needs.

---

## Environment Configuration

### Environment Files

The project uses environment files to manage configuration:

- `.env` - Default configuration (committed to Git)
- `.env.local` - Local overrides (not committed)
- `.env.test` - Test environment

{: .important }
Never commit `.env.local` to version control. It contains sensitive information.

### Creating Local Configuration

```bash
cp .env .env.local
```

Edit `.env.local` to override default settings.

---

## Database Configuration

### Connection Settings

In `.env.local`:

```env
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/school_db?serverVersion=8.0"
```

**Parameters:**
- `db_user` - MySQL username
- `db_password` - MySQL password
- `127.0.0.1` - Host (or `mysql` for Docker)
- `3306` - Port
- `school_db` - Database name
- `serverVersion=8.0` - MySQL version

### Docker Configuration

For Docker, use:

```env
DATABASE_URL="mysql://root:root@mysql:3306/school_db?serverVersion=8.0"
```

### Test Database

In `.env.test`:

```env
DATABASE_URL="mysql://root:root@mysql:3306/school_db_test?serverVersion=8.0"
```

---

## Application Configuration

### Debug Mode

```env
# Development
APP_ENV=dev
APP_DEBUG=1

# Production
APP_ENV=prod
APP_DEBUG=0
```

{: .warning }
Never enable debug mode in production. It exposes sensitive information.

### Secret Key

```env
APP_SECRET=your-secret-key-here
```

Generate a new secret for production:

```bash
php -r "echo bin2hex(random_bytes(16));"
```

---

## Locale and Language

### Default Locale

In `config/packages/translation.yaml`:

```yaml
framework:
    default_locale: fr  # fr, en, or ar
    translator:
        default_path: '%kernel.project_dir%/translations'
        fallbacks:
            - en
```

### Available Locales

The system supports:
- `fr` - French (Français)
- `en` - English
- `ar` - Arabic (العربية) with RTL support

### Adding a New Language

1. Create translation files:
   ```bash
   touch translations/messages.es.yaml
   touch translations/EasyAdminBundle.es.yaml
   ```

2. Add translations:
   ```yaml
   # messages.es.yaml
   student: Estudiante
   class: Clase
   professor: Profesor
   ```

3. Update configuration:
   ```yaml
   # config/packages/translation.yaml
   framework:
       translator:
           fallbacks:
               - en
               - es
   ```

---

## EasyAdmin Configuration

### Dashboard Configuration

Edit `src/Controller/Admin/DashboardController.php`:

```php
public function configureDashboard(): Dashboard
{
    return Dashboard::new()
        ->setTitle('School Management')
        ->setFaviconPath('favicon.ico')
        ->setLocales(['en', 'fr', 'ar'])
        ->renderContentMaximized();
}
```

### Menu Configuration

```php
public function configureMenuItems(): iterable
{
    yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
    yield MenuItem::linkToCrud('Students', 'fa fa-user', Etudiant::class);
    yield MenuItem::linkToCrud('Classes', 'fa fa-school', Classe::class);
    // Add more menu items...
}
```

---

## Doctrine Configuration

### Entity Manager

In `config/packages/doctrine.yaml`:

```yaml
doctrine:
    dbal:
        url: '%env(resolve:DATABASE_URL)%'
        charset: utf8mb4
        default_table_options:
            charset: utf8mb4
            collate: utf8mb4_unicode_ci

    orm:
        auto_generate_proxy_classes: true
        naming_strategy: doctrine.orm.naming_strategy.underscore_number_aware
        auto_mapping: true
```

### Migration Configuration

In `config/packages/doctrine_migrations.yaml`:

```yaml
doctrine_migrations:
    migrations_paths:
        'DoctrineMigrations': '%kernel.project_dir%/migrations'
    enable_profiler: false
```

---

## Web Server Configuration

### Docker Configuration

Edit `docker-compose.yml`:

```yaml
services:
  nginx:
    ports:
      - "8080:80"  # Change port here

  mysql:
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: school_db
      MYSQL_USER: school_user
      MYSQL_PASSWORD: school_pass
```

### Nginx Configuration

In `docker/nginx/default.conf`:

```nginx
server {
    listen 80;
    server_name localhost;
    root /var/www/html/public;

    location / {
        try_files $uri /index.php$is_args$args;
    }

    location ~ ^/index\.php(/|$) {
        fastcgi_pass php:9000;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    }
}
```

---

## Logging Configuration

### Log Levels

In `config/packages/monolog.yaml`:

```yaml
monolog:
    channels:
        - deprecation

when@dev:
    monolog:
        handlers:
            main:
                type: stream
                path: "%kernel.logs_dir%/%kernel.environment%.log"
                level: debug

when@prod:
    monolog:
        handlers:
            main:
                type: fingers_crossed
                action_level: error
                handler: nested
            nested:
                type: stream
                path: "%kernel.logs_dir%/%kernel.environment%.log"
                level: debug
```

### Viewing Logs

```bash
# Docker
docker-compose logs -f php

# Local
tail -f var/log/dev.log
```

---

## Cache Configuration

### Cache Pools

In `config/packages/cache.yaml`:

```yaml
framework:
    cache:
        app: cache.adapter.filesystem
        system: cache.adapter.system
```

### Clear Cache

```bash
# Development
php bin/console cache:clear

# Production
php bin/console cache:clear --env=prod --no-debug
```

---

## Security Configuration

### Firewall

In `config/packages/security.yaml`:

```yaml
security:
    password_hashers:
        Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface: 'auto'

    providers:
        app_user_provider:
            entity:
                class: App\Entity\User
                property: username

    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false
        main:
            lazy: true
            provider: app_user_provider
```

---

## Performance Optimization

### Production Optimizations

```bash
# Optimize Composer autoloader
composer install --no-dev --optimize-autoloader

# Dump environment variables
composer dump-env prod

# Warm up cache
php bin/console cache:warmup --env=prod
```

### OPcache Configuration

In `docker/php/php.ini`:

```ini
[opcache]
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=20000
opcache.validate_timestamps=0
```

---

## Email Configuration

### Mailer Settings

In `.env.local`:

```env
MAILER_DSN=smtp://user:pass@smtp.example.com:587
```

### Supported Transports

```env
# SMTP
MAILER_DSN=smtp://user:pass@smtp.gmail.com:587

# Sendmail
MAILER_DSN=sendmail://default

# Null (testing)
MAILER_DSN=null://null
```

---

## Fixtures Configuration

### Customize Demo Data

Edit `src/DataFixtures/AppFixtures.php`:

```php
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Change number of students
        $this->createStudents($manager, 100);  // Default: 50

        // Change number of classes
        $this->createClasses($manager, 10);    // Default: 5
    }
}
```

### Load Specific Fixtures

```bash
# Load all fixtures
php bin/console doctrine:fixtures:load

# Load specific fixture
php bin/console doctrine:fixtures:load --append --group=students
```

---

## Advanced Configuration

### Custom Parameters

In `config/services.yaml`:

```yaml
parameters:
    app.max_students_per_class: 30
    app.school_year: '2025-2026'
    app.grade_scale: 20

services:
    _defaults:
        autowire: true
        autoconfigure: true
        bind:
            $maxStudentsPerClass: '%app.max_students_per_class%'
```

---

## Configuration Files Reference

| File | Purpose |
|------|---------|
| `.env` | Default environment configuration |
| `.env.local` | Local overrides (not committed) |
| `config/packages/` | Bundle configurations |
| `config/routes.yaml` | Routing configuration |
| `config/services.yaml` | Service container |
| `docker-compose.yml` | Docker services |
| `castor.php` | Task runner configuration |

---

## Next Steps

- [Quick Start Guide](quick-start.md)
- [User Guide](../user-guide/index.md)
- [Development Guide](../development/index.md)

---

## Troubleshooting Configuration

### Configuration Issues

**Problem**: Configuration not loading

**Solution**: Clear cache
```bash
php bin/console cache:clear
```

**Problem**: Database connection fails

**Solution**: Check `DATABASE_URL` in `.env.local`

**Problem**: Locale not changing

**Solution**: Clear cache and check translation files exist

---

**Configuration complete!** Continue to [Quick Start](quick-start.md).
