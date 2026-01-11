# 🎓 Système de Gestion Scolaire - Symfony 7.4 + EasyAdmin

Système de gestion scolaire moderne migré de Symfony 3.1 vers Symfony 7.4 avec interface d'administration EasyAdmin.

## 📋 Fonctionnalités

- ✅ Gestion des étudiants
- ✅ Gestion des professeurs
- ✅ Gestion des classes
- ✅ Gestion des notes et évaluations
- ✅ Suivi des absences
- ✅ Gestion des séances et emploi du temps
- ✅ Gestion des exercices
- ✅ Interface d'administration moderne avec EasyAdmin 4
- ✅ Authentification sécurisée

## 🚀 Installation avec Docker

### Prérequis
- Docker
- Docker Compose

### Étapes d'installation

1. **Cloner le projet** (si ce n'est pas déjà fait)
```bash
cd /home/ahmed/Projets/old-school-project
```

2. **Démarrer les conteneurs Docker**
```bash
docker-compose up -d
```

3. **Installer les dépendances Composer**
```bash
docker-compose exec php composer install
```

4. **Créer la base de données et les tables**
```bash
docker-compose exec php php bin/console doctrine:database:create --if-not-exists
docker-compose exec php php bin/console make:migration
docker-compose exec php php bin/console doctrine:migrations:migrate -n
```

5. **Créer un utilisateur administrateur**
```bash
# Hasher le mot de passe
docker-compose exec php php bin/console security:hash-password
# Puis insérer manuellement dans la base via PhpMyAdmin ou SQL
```

6. **Vider le cache**
```bash
docker-compose exec php php bin/console cache:clear
```

## 🌐 Accès à l'application

- **Application web**: http://localhost:8080
- **Interface admin**: http://localhost:8080/admin
- **Connexion**: http://localhost:8080/login
- **PhpMyAdmin**: http://localhost:8081
  - Serveur: `db`
  - Utilisateur: `root`
  - Mot de passe: `root`

### Identifiants par défaut
Vous devez créer un utilisateur administrateur après l'installation.

## 📦 Services Docker

- **nginx**: Serveur web (port 8080)
- **php**: PHP 8.4-FPM
- **db**: MySQL 8.0 (port 3306)
- **phpmyadmin**: Interface de gestion MySQL (port 8081)

## 🛠️ Commandes utiles

Ce projet propose **3 façons** de gérer les tâches:

### Option 1: Castor (recommandé) 🎯

Castor est un task runner moderne pour PHP. Installez les dépendances puis utilisez:

```bash
# Lister toutes les commandes disponibles
vendor/bin/castor

# Build complet du projet
vendor/bin/castor build

# Démarrer/arrêter
vendor/bin/castor start
vendor/bin/castor stop
vendor/bin/castor restart

# Base de données
vendor/bin/castor db:init
vendor/bin/castor db:migrate
vendor/bin/castor db:reset

# Cache et logs
vendor/bin/castor cache
vendor/bin/castor logs

# Créer un admin
vendor/bin/castor create-admin

# Autres
vendor/bin/castor routes
vendor/bin/castor shell
vendor/bin/castor test
```

### Option 2: Makefile ⚙️

Si vous préférez Make:

```bash
# Lister toutes les commandes
make help

# Build complet
make build

# Démarrer/arrêter
make start
make stop
make restart
make status

# Base de données
make db-init
make db-migrate
make db-reset

# Cache et utilitaires
make cache
make logs
make routes
make shell

# Créer un admin
make create-admin
```

### Option 3: Docker Compose direct 🐳

Pour les puristes:

```bash
# Démarrer les conteneurs
docker-compose up -d

# Arrêter les conteneurs
docker-compose down

# Voir les logs
docker-compose logs -f

# Exécuter des commandes
docker-compose exec php php bin/console

# Créer une migration
docker-compose exec php php bin/console make:migration

# Exécuter les migrations
docker-compose exec php php bin/console doctrine:migrations:migrate

# Vider le cache
docker-compose exec php php bin/console cache:clear
```

## 📊 Structure du projet

```
.
├── config/              # Configuration Symfony
├── docker/             # Configuration Docker
├── public/             # Point d'entrée web
├── src/
│   ├── Controller/     # Contrôleurs
│   │   └── Admin/      # Contrôleurs EasyAdmin
│   ├── Entity/         # Entités Doctrine
│   └── Repository/     # Repositories Doctrine
├── templates/          # Templates Twig
├── var/                # Cache et logs
├── docker-compose.yml  # Configuration Docker Compose
└── Dockerfile          # Image Docker PHP
```

## 🔧 Configuration

### Variables d'environnement (.env)

```env
APP_ENV=dev
APP_SECRET=ThisTokenIsNotSoSecretChangeIt
DATABASE_URL="mysql://ecole_user:ecole_pass@db:3306/ecole?serverVersion=8.0&charset=utf8mb4"
```

### Modifier le mot de passe de la base de données

1. Éditer `docker-compose.yml`:
```yaml
MYSQL_PASSWORD: votre_nouveau_mot_de_passe
```

2. Mettre à jour `.env`:
```env
DATABASE_URL="mysql://ecole_user:votre_nouveau_mot_de_passe@db:3306/ecole?serverVersion=8.0&charset=utf8mb4"
```

3. Redémarrer les conteneurs:
```bash
docker-compose down -v
docker-compose up -d
```

## 🎨 Personnalisation EasyAdmin

Les contrôleurs CRUD se trouvent dans `src/Controller/Admin/`. Vous pouvez personnaliser:
- Les champs affichés
- Les filtres
- Les actions
- Les permissions

Exemple dans `src/Controller/Admin/EtudiantCrudController.php`

## 🔒 Sécurité

- Authentification par formulaire
- Mots de passe hashés avec l'algorithme auto de Symfony
- Protection CSRF activée
- Accès admin restreint aux utilisateurs avec ROLE_ADMIN

## 📝 Notes de migration

Ce projet a été migré de Symfony 3.1 vers Symfony 7.4:
- ✅ Architecture modernisée (plus de bundles)
- ✅ Attributs PHP 8 au lieu d'annotations
- ✅ EasyAdmin 4 pour l'interface admin
- ✅ Docker pour le développement
- ✅ Symfony 7.4 LTS
- ✅ Toutes les entités migrées (8 entités)
- ✅ Interface d'administration complète

## 🐛 Dépannage

### Problèmes de permissions
```bash
docker-compose exec php chown -R www-data:www-data /var/www/var
docker-compose exec php chmod -R 775 /var/www/var
```

### Cache corrompu
```bash
docker-compose exec php php bin/console cache:clear --no-warmup
docker-compose exec php php bin/console cache:warmup
```

### Base de données non accessible
```bash
# Vérifier que le conteneur DB est démarré
docker-compose ps

# Voir les logs du conteneur DB
docker-compose logs db
```

## 📄 Licence

Propriétaire

## 👤 Auteur

Ahmed - Système de gestion scolaire
Migré vers Symfony 7.4 en 2026
