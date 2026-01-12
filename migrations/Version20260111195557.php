<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260111195557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, nombre INT NOT NULL, etudiant_id INT DEFAULT NULL, INDEX IDX_765AE0C9DDEAB1A3 (etudiant_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, annee VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, adresse VARCHAR(255) NOT NULL, nom_pere VARCHAR(255) NOT NULL, nom_mere VARCHAR(255) NOT NULL, numero_tel INT NOT NULL, genre VARCHAR(255) NOT NULL, status TINYINT DEFAULT NULL, classe_id INT NOT NULL, INDEX IDX_717E22E38F5EA509 (classe_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, semestre VARCHAR(255) NOT NULL, coef DOUBLE PRECISION NOT NULL, date DATETIME NOT NULL, classe_id INT DEFAULT NULL, prof_id INT DEFAULT NULL, INDEX IDX_1323A5758F5EA509 (classe_id), INDEX IDX_1323A575ABC1F7FE (prof_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE exercice (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, date DATETIME NOT NULL, classe_id INT DEFAULT NULL, INDEX IDX_E418C74D8F5EA509 (classe_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, valeur DOUBLE PRECISION DEFAULT NULL, classe_id INT DEFAULT NULL, evaluation_id INT DEFAULT NULL, etudiant_id INT DEFAULT NULL, INDEX IDX_CFBDFA148F5EA509 (classe_id), INDEX IDX_CFBDFA14456C5646 (evaluation_id), INDEX IDX_CFBDFA14DDEAB1A3 (etudiant_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE prof (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, cin INT NOT NULL, date_naissance DATETIME NOT NULL, genre VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, competences LONGTEXT NOT NULL, adresse VARCHAR(255) NOT NULL, numero_tel INT NOT NULL, debut DATETIME NOT NULL, fin DATETIME NOT NULL, UNIQUE INDEX UNIQ_5BBA70BBABE530DA (cin), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE seance (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, debut DATETIME DEFAULT NULL, date DATETIME DEFAULT NULL, jour INT NOT NULL, classe_id INT NOT NULL, prof_id INT DEFAULT NULL, INDEX IDX_DF7DFD0E8F5EA509 (classe_id), INDEX IDX_DF7DFD0EABC1F7FE (prof_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E38F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5758F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575ABC1F7FE FOREIGN KEY (prof_id) REFERENCES prof (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE exercice ADD CONSTRAINT FK_E418C74D8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA148F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0E8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EABC1F7FE FOREIGN KEY (prof_id) REFERENCES prof (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9DDEAB1A3');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E38F5EA509');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5758F5EA509');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575ABC1F7FE');
        $this->addSql('ALTER TABLE exercice DROP FOREIGN KEY FK_E418C74D8F5EA509');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA148F5EA509');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14456C5646');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14DDEAB1A3');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0E8F5EA509');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0EABC1F7FE');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE exercice');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE prof');
        $this->addSql('DROP TABLE seance');
        $this->addSql('DROP TABLE `user`');
    }
}
