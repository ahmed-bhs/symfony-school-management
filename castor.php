<?php

use Castor\Attribute\AsTask;

use function Castor\io;
use function Castor\run;
use function Castor\task;
use function Castor\parallel;

/**
 * 🚀 Démarre tous les conteneurs Docker
 */
#[AsTask(description: 'Démarre tous les conteneurs Docker')]
function start(): void
{
    io()->title('🚀 Démarrage des conteneurs Docker');
    run('docker-compose up -d');
    io()->success('Conteneurs démarrés avec succès!');
    status();
}

/**
 * 🛑 Arrête tous les conteneurs Docker
 */
#[AsTask(description: 'Arrête tous les conteneurs Docker')]
function stop(): void
{
    io()->title('🛑 Arrêt des conteneurs Docker');
    run('docker-compose down');
    io()->success('Conteneurs arrêtés avec succès!');
}

/**
 * 🔄 Redémarre tous les conteneurs Docker
 */
#[AsTask(description: 'Redémarre tous les conteneurs Docker')]
function restart(): void
{
    io()->title('🔄 Redémarrage des conteneurs Docker');
    stop();
    start();
}

/**
 * 📊 Affiche le statut des conteneurs
 */
#[AsTask(description: 'Affiche le statut des conteneurs Docker')]
function status(): void
{
    io()->title('📊 Statut des conteneurs');
    run('docker-compose ps');

    io()->newLine();
    io()->section('🌐 URLs d\'accès');
    io()->writeln('  Application: <href=http://localhost:8080>http://localhost:8080</>');
    io()->writeln('  Admin: <href=http://localhost:8080/admin>http://localhost:8080/admin</>');
    io()->writeln('  Login: <href=http://localhost:8080/login>http://localhost:8080/login</>');
    io()->writeln('  PhpMyAdmin: <href=http://localhost:8081>http://localhost:8081</>');
}

/**
 * 📦 Installe toutes les dépendances du projet
 */
#[AsTask(description: 'Installe les dépendances Composer')]
function install(): void
{
    io()->title('📦 Installation des dépendances');
    run('docker-compose exec -T php composer install --no-interaction');
    io()->success('Dépendances installées avec succès!');
}

/**
 * 🗄️ Initialise la base de données (création + migrations)
 */
#[AsTask(description: 'Initialise la base de données')]
function dbInit(): void
{
    io()->title('🗄️ Initialisation de la base de données');

    io()->section('Création de la base de données');
    run('docker-compose exec -T php php bin/console doctrine:database:create --if-not-exists');

    io()->section('Exécution des migrations');
    run('docker-compose exec -T php php bin/console doctrine:migrations:migrate --no-interaction');

    io()->success('Base de données initialisée avec succès!');
}

/**
 * 📝 Crée une nouvelle migration
 */
#[AsTask(description: 'Crée une nouvelle migration')]
function dbMigrate(): void
{
    io()->title('📝 Création d\'une migration');
    run('docker-compose exec php php bin/console make:migration');
}

/**
 * ⚡ Exécute les migrations en attente
 */
#[AsTask(description: 'Exécute les migrations')]
function dbMigrateRun(): void
{
    io()->title('⚡ Exécution des migrations');
    run('docker-compose exec -T php php bin/console doctrine:migrations:migrate --no-interaction');
    io()->success('Migrations exécutées avec succès!');
}

/**
 * 🗑️ Supprime et recrée la base de données
 */
#[AsTask(description: 'Reset complet de la base de données')]
function dbReset(): void
{
    if (!io()->confirm('⚠️  Êtes-vous sûr de vouloir supprimer toute la base de données ?', false)) {
        io()->warning('Opération annulée');
        return;
    }

    io()->title('🗑️ Reset de la base de données');

    io()->section('Suppression de la base');
    run('docker-compose exec -T php php bin/console doctrine:database:drop --force --if-exists');

    io()->section('Recréation de la base');
    dbInit();

    io()->success('Base de données réinitialisée avec succès!');
}

/**
 * 🧹 Vide le cache Symfony
 */
#[AsTask(description: 'Vide le cache Symfony')]
function cache(): void
{
    io()->title('🧹 Nettoyage du cache');
    run('docker-compose exec -T php php bin/console cache:clear');
    io()->success('Cache vidé avec succès!');
}

/**
 * 📋 Affiche les logs des conteneurs
 */
#[AsTask(description: 'Affiche les logs des conteneurs')]
function logs(string $service = ''): void
{
    io()->title('📋 Logs des conteneurs');

    if ($service) {
        run("docker-compose logs -f {$service}");
    } else {
        run('docker-compose logs -f');
    }
}

/**
 * 🔒 Crée un hash de mot de passe
 */
#[AsTask(description: 'Hash un mot de passe pour un utilisateur')]
function hashPassword(): void
{
    io()->title('🔒 Générateur de hash de mot de passe');
    run('docker-compose exec php php bin/console security:hash-password');
}

/**
 * 👤 Crée un utilisateur administrateur
 */
#[AsTask(description: 'Crée un utilisateur administrateur')]
function createAdmin(): void
{
    io()->title('👤 Création d\'un utilisateur administrateur');

    $email = io()->ask('Email de l\'administrateur', 'admin@ecole.com');

    io()->writeln('Veuillez hasher votre mot de passe:');
    run('docker-compose exec php php bin/console security:hash-password');

    $hashedPassword = io()->ask('Entrez le hash du mot de passe');

    $sql = sprintf(
        "INSERT INTO user (email, roles, password) VALUES ('%s', '[\"ROLE_ADMIN\",\"ROLE_USER\"]', '%s');",
        $email,
        $hashedPassword
    );

    run("docker-compose exec -T db mysql -uroot -proot ecole -e \"{$sql}\"");

    io()->success("Administrateur créé avec succès: {$email}");
}

/**
 * 🧪 Exécute les tests
 */
#[AsTask(description: 'Exécute les tests PHPUnit')]
function test(): void
{
    io()->title('🧪 Exécution des tests');
    run('docker-compose exec -T php php bin/phpunit');
}

/**
 * 🏗️ Build complet du projet (installation + DB + cache)
 */
#[AsTask(description: 'Build complet du projet')]
function build(): void
{
    io()->title('🏗️ Build complet du projet');

    io()->section('1/5 - Démarrage des conteneurs');
    start();

    io()->section('2/5 - Attente du démarrage de MySQL');
    sleep(10);

    io()->section('3/5 - Installation des dépendances');
    install();

    io()->section('4/5 - Initialisation de la base de données');
    dbInit();

    io()->section('5/5 - Nettoyage du cache');
    cache();

    io()->newLine();
    io()->success('🎉 Build terminé avec succès!');
    io()->newLine();
    status();
}

/**
 * 🔍 Ouvre un shell dans un conteneur
 */
#[AsTask(description: 'Ouvre un shell dans un conteneur')]
function shell(string $service = 'php'): void
{
    io()->title("🔍 Ouverture d'un shell dans le conteneur {$service}");
    run("docker-compose exec {$service} /bin/bash", tty: true);
}

/**
 * 🎨 Affiche toutes les routes de l'application
 */
#[AsTask(description: 'Liste toutes les routes')]
function routes(): void
{
    io()->title('🎨 Routes de l\'application');
    run('docker-compose exec php php bin/console debug:router');
}

/**
 * 📊 Affiche les informations du schéma de base de données
 */
#[AsTask(description: 'Affiche le schéma de la base de données')]
function dbSchema(): void
{
    io()->title('📊 Schéma de la base de données');
    run('docker-compose exec php php bin/console doctrine:schema:update --dump-sql');
}

/**
 * 🧼 Nettoie complètement le projet (stop + suppression volumes)
 */
#[AsTask(description: 'Nettoie complètement le projet')]
function clean(): void
{
    if (!io()->confirm('⚠️  Cela va supprimer tous les volumes Docker. Continuer ?', false)) {
        io()->warning('Opération annulée');
        return;
    }

    io()->title('🧼 Nettoyage complet du projet');
    run('docker-compose down -v');
    io()->success('Projet nettoyé avec succès!');
}
