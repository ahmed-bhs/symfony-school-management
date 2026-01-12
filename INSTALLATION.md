# 📦 Guide d'Installation

## ✅ Migration Terminée !

Votre projet a été **migré avec succès** de Symfony 3.1 vers Symfony 7.4 avec EasyAdmin 4.

## 🚨 Prérequis

Pour lancer le projet, vous devez installer Docker et Docker Compose.

### Installation de Docker

#### Sur Ubuntu/Debian
```bash
# Installer Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Ajouter votre utilisateur au groupe docker
sudo usermod -aG docker $USER

# Démarrer Docker
sudo systemctl start docker
sudo systemctl enable docker

# Se reconnecter pour que les permissions prennent effet
newgrp docker
```

#### Sur Fedora/RHEL
```bash
sudo dnf install docker docker compose
sudo systemctl start docker
sudo systemctl enable docker
sudo usermod -aG docker $USER
newgrp docker
```

#### Sur macOS
```bash
# Installer Docker Desktop
brew install --cask docker
# Puis lancer Docker Desktop depuis les Applications
```

#### Sur Windows
Téléchargez et installez [Docker Desktop](https://www.docker.com/products/docker-desktop)

### Installation de Docker Compose

Docker Compose est généralement inclus avec Docker Desktop. Si ce n'est pas le cas:

```bash
# Linux
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker compose
sudo chmod +x /usr/local/bin/docker compose

# Vérifier l'installation
docker compose --version
```

## 🚀 Lancement du Projet

Une fois Docker et Docker Compose installés:

### Option 1: Installation Rapide avec Démo
```bash
cd /home/ahmed/Projets/old-school-project
make demo
```

Cette commande va:
1. ✅ Démarrer tous les conteneurs Docker
2. ✅ Installer les dépendances
3. ✅ Créer la base de données
4. ✅ Exécuter les migrations
5. ✅ Charger les données de démo (21 classes, 16 profs, 300+ étudiants)
6. ✅ Créer l'utilisateur admin

### Option 2: Installation Manuelle
```bash
# Démarrer les conteneurs
make start

# Installer les dépendances
make install

# Créer la base de données
make db-init

# Charger les données de démo (optionnel)
make db-fixtures
```

## 🌐 Accès à l'Application

Après l'installation, accédez à:

| Service | URL | Identifiants |
|---------|-----|--------------|
| **Application** | http://localhost:8080 | - |
| **Interface Admin** | http://localhost:8080/admin | admin@ecole.com / admin |
| **Page de Connexion** | http://localhost:8080/login | admin@ecole.com / admin |
| **PhpMyAdmin** | http://localhost:8081 | root / root |

## 📊 Données de Démonstration

Si vous avez lancé `make demo` ou `make db-fixtures`, le système contient:

- **1 utilisateur admin** - admin@ecole.com / admin
- **21 classes** - De la 6ème à la Terminale (3 sections par niveau)
- **16 professeurs** - 8 matières différentes
- **300+ étudiants** - Répartis dans les classes
- **Emploi du temps complet** - Séances programmées
- **Évaluations et notes** - Pour tous les étudiants
- **Absences** - 30% des étudiants
- **Exercices** - Pour chaque classe

## 🛠️ Commandes Utiles

```bash
# Voir toutes les commandes disponibles
make help

# Gérer les conteneurs
make start          # Démarrer
make stop           # Arrêter
make restart        # Redémarrer
make status         # Voir le statut

# Base de données
make db-init        # Initialiser
make db-reset       # Réinitialiser
make db-fixtures    # Charger les données de démo

# Développement
make cache          # Vider le cache
make logs           # Voir les logs
make shell          # Ouvrir un terminal
```

## 🐛 Dépannage

### Docker n'est pas installé
```
Error: docker compose: command not found
```
→ Installez Docker en suivant les instructions ci-dessus

### Port déjà utilisé
```
Error: port is already allocated
```
→ Modifiez les ports dans `docker compose.yml`:
```yaml
ports:
  - "8081:80"  # Changez 8080 en 8081
```

### Problèmes de permissions
```bash
sudo chown -R $USER:$USER .
chmod +x bin/console start.sh
```

### MySQL ne démarre pas
```bash
# Voir les logs
docker compose logs db

# Redémarrer MySQL
docker compose restart db
```

## 📚 Documentation

- **README.md** - Documentation complète
- **QUICKSTART.md** - Guide de démarrage rapide
- **MIGRATION_COMPLETE.md** - Détails de la migration

## ✨ Prochaines Étapes

1. Connectez-vous à l'admin: http://localhost:8080/admin
2. Explorez les différentes sections (Étudiants, Professeurs, Classes, etc.)
3. Testez les fonctionnalités CRUD
4. Personnalisez l'interface selon vos besoins

## 🎓 Support

Pour toute question:
1. Consultez la documentation dans README.md
2. Vérifiez les logs: `make logs`
3. Réinitialisez si nécessaire: `make clean && make demo`

---

**Le projet est prêt ! Il ne manque que Docker pour le lancer.** 🚀
