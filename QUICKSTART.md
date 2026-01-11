# 🚀 Guide de Démarrage Rapide

## Installation en 3 étapes

### 1️⃣ Démarrer le projet

Choisissez votre méthode préférée:

**Avec le script bash:**
```bash
./start.sh
```

**Avec Make:**
```bash
make build
```

**Avec Castor (après install):**
```bash
docker-compose up -d
docker-compose exec -T php composer install
vendor/bin/castor build
```

### 2️⃣ Créer un utilisateur administrateur

```bash
# Générer le hash du mot de passe
make hash-password
# ou
docker-compose exec php php bin/console security:hash-password

# Insérer l'utilisateur via PhpMyAdmin (http://localhost:8081)
# ou via la commande:
make create-admin
```

**SQL manuel:**
```sql
INSERT INTO user (email, roles, password)
VALUES ('admin@ecole.com', '["ROLE_ADMIN","ROLE_USER"]', 'VOTRE_HASH_ICI');
```

### 3️⃣ Accéder à l'application

- 🌐 Application: **http://localhost:8080**
- 🔐 Connexion: **http://localhost:8080/login**
- ⚙️ Admin: **http://localhost:8080/admin**
- 💾 PhpMyAdmin: **http://localhost:8081**

## Commandes Essentielles

### Démarrage/Arrêt
```bash
make start      # Démarrer
make stop       # Arrêter
make restart    # Redémarrer
make status     # Voir le statut
```

### Base de données
```bash
make db-init    # Créer et migrer
make db-migrate # Nouvelle migration
make db-reset   # Tout supprimer et recréer
```

### Développement
```bash
make cache      # Vider le cache
make logs       # Voir les logs
make shell      # Ouvrir un terminal
make routes     # Lister les routes
```

## Résolution de problèmes

### Les conteneurs ne démarrent pas
```bash
docker-compose ps     # Vérifier l'état
docker-compose logs   # Voir les erreurs
```

### Problèmes de permissions
```bash
docker-compose exec php chown -R www-data:www-data /var/www/var
docker-compose exec php chmod -R 775 /var/www/var
```

### Base de données inaccessible
```bash
# Attendre que MySQL démarre complètement
sleep 10
make db-init
```

### Cache corrompu
```bash
make cache
# ou
rm -rf var/cache/*
```

## Structure des Entités

Le système gère 8 entités principales:

1. **Etudiant** - Étudiants et leurs informations
2. **Prof** - Professeurs et leurs compétences
3. **Classe** - Classes et années scolaires
4. **Note** - Notes des évaluations
5. **Evaluation** - Tests et examens
6. **Seance** - Cours et emploi du temps
7. **Absence** - Suivi des absences
8. **Exercice** - Devoirs et exercices

Toutes accessibles via EasyAdmin à: **http://localhost:8080/admin**

## Étapes suivantes

1. ✅ Créer votre premier utilisateur admin
2. ✅ Se connecter à l'interface admin
3. ✅ Ajouter des classes
4. ✅ Ajouter des professeurs
5. ✅ Ajouter des étudiants
6. ✅ Créer des évaluations
7. ✅ Saisir des notes

Bon développement ! 🎓
