.PHONY: help start stop restart status install db-init db-migrate db-migrate-run db-reset cache logs hash-password create-admin test build shell routes db-schema clean

.DEFAULT_GOAL := help

help: ## Affiche cette aide
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

# Docker
start: ## 🚀 Démarre tous les conteneurs Docker
	docker-compose up -d
	@echo "✅ Conteneurs démarrés"
	@make status

stop: ## 🛑 Arrête tous les conteneurs Docker
	docker-compose down
	@echo "✅ Conteneurs arrêtés"

restart: ## 🔄 Redémarre tous les conteneurs
	@make stop
	@make start

status: ## 📊 Affiche le statut des conteneurs
	@echo "\n📊 Statut des conteneurs:"
	@docker-compose ps
	@echo "\n🌐 URLs d'accès:"
	@echo "  Application:  http://localhost:8080"
	@echo "  Admin:        http://localhost:8080/admin"
	@echo "  Login:        http://localhost:8080/login"
	@echo "  PhpMyAdmin:   http://localhost:8081"

# Installation
install: ## 📦 Installe les dépendances Composer
	docker-compose exec -T php composer install --no-interaction
	@echo "✅ Dépendances installées"

# Base de données
db-init: ## 🗄️ Initialise la base de données
	docker-compose exec -T php php bin/console doctrine:database:create --if-not-exists
	docker-compose exec -T php php bin/console doctrine:migrations:migrate --no-interaction
	@echo "✅ Base de données initialisée"

db-migrate: ## 📝 Crée une nouvelle migration
	docker-compose exec php php bin/console make:migration

db-migrate-run: ## ⚡ Exécute les migrations
	docker-compose exec -T php php bin/console doctrine:migrations:migrate --no-interaction
	@echo "✅ Migrations exécutées"

db-reset: ## 🗑️ Reset complet de la base de données
	@echo "⚠️  Suppression de la base de données..."
	docker-compose exec -T php php bin/console doctrine:database:drop --force --if-exists
	@make db-init
	@echo "✅ Base de données réinitialisée"

db-schema: ## 📊 Affiche le schéma SQL
	docker-compose exec php php bin/console doctrine:schema:update --dump-sql

db-fixtures: ## 🌱 Charge les fixtures (données de test)
	docker-compose exec -T php php bin/console doctrine:fixtures:load --no-interaction
	@echo "✅ Fixtures chargées"

# Cache
cache: ## 🧹 Vide le cache Symfony
	docker-compose exec -T php php bin/console cache:clear
	@echo "✅ Cache vidé"

# Logs
logs: ## 📋 Affiche les logs (logs service=php pour un service spécifique)
	docker-compose logs -f $(service)

# Sécurité
hash-password: ## 🔒 Hash un mot de passe
	docker-compose exec php php bin/console security:hash-password

create-admin: ## 👤 Crée un utilisateur admin (interactive)
	@echo "👤 Création d'un administrateur"
	@read -p "Email [admin@ecole.com]: " email; \
	email=$${email:-admin@ecole.com}; \
	echo "Hashage du mot de passe..."; \
	docker-compose exec php php bin/console security:hash-password; \
	read -p "Hash du mot de passe: " hash; \
	docker-compose exec -T db mysql -uroot -proot ecole -e "INSERT INTO user (email, roles, password) VALUES ('$$email', '[\"ROLE_ADMIN\",\"ROLE_USER\"]', '$$hash');" && \
	echo "✅ Admin créé: $$email"

# Tests
test: ## 🧪 Exécute les tests
	docker-compose exec -T php php bin/phpunit

# Build
build: ## 🏗️ Build complet du projet
	@echo "🏗️  Build complet du projet..."
	@make start
	@echo "⏳ Attente MySQL..."
	@sleep 10
	@make install
	@make db-init
	@make cache
	@echo "\n🎉 Build terminé!"
	@make status

# Utilitaires
shell: ## 🔍 Ouvre un shell (shell service=nginx pour autre service)
	docker-compose exec $(or $(service),php) /bin/bash

routes: ## 🎨 Liste toutes les routes
	docker-compose exec php php bin/console debug:router

clean: ## 🧼 Nettoie le projet (supprime les volumes)
	@echo "⚠️  Suppression de tous les volumes..."
	docker-compose down -v
	@echo "✅ Projet nettoyé"

# Démo
demo: ## 🎉 Installation complète avec données de démo
	@echo "🎉 Installation complète avec données de démo..."
	@make build
	@make db-fixtures
	@echo "\n✨ Démo prête!"
	@echo "\n👤 Utilisateur admin créé:"
	@echo "   Email: admin@ecole.com"
	@echo "   Mot de passe: admin"
	@make status

# Raccourcis
up: start ## Alias pour start
down: stop ## Alias pour stop
