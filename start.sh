#!/bin/bash

echo "🚀 Démarrage du projet Gestion Scolaire..."
echo ""

# Démarrer Docker Compose
echo "📦 Démarrage des conteneurs Docker..."
docker compose up -d

# Attendre que MySQL soit prêt
echo "⏳ Attente du démarrage de MySQL..."
sleep 10

# Installer les dépendances
echo "📥 Installation des dépendances Composer..."
docker compose exec -T php composer install --no-interaction

# Créer la base de données
echo "🗄️  Création de la base de données..."
docker compose exec -T php php bin/console doctrine:database:create --if-not-exists

# Créer les migrations
echo "📝 Création des migrations..."
docker compose exec -T php php bin/console make:migration --no-interaction || echo "Migration déjà créée"

# Exécuter les migrations
echo "⚡ Exécution des migrations..."
docker compose exec -T php php bin/console doctrine:migrations:migrate --no-interaction

# Vider le cache
echo "🧹 Nettoyage du cache..."
docker compose exec -T php php bin/console cache:clear

echo ""
echo "✅ Installation terminée!"
echo ""
echo "🌐 Accès à l'application:"
echo "   - Application: http://localhost:8080"
echo "   - Admin: http://localhost:8080/admin"
echo "   - PhpMyAdmin: http://localhost:8081"
echo ""
echo "⚠️  N'oubliez pas de créer un utilisateur admin!"
echo "   docker compose exec php php bin/console security:hash-password"
echo ""
