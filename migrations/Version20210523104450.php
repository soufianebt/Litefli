<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210523104450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE centre (id INT AUTO_INCREMENT NOT NULL, nom_centre VARCHAR(255) DEFAULT NULL, code_postal INT DEFAULT NULL, username VARCHAR(40) NOT NULL, mdp VARCHAR(255) NOT NULL, type_compte VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, type_compte VARCHAR(255) NOT NULL, nom_complet VARCHAR(255) NOT NULL, code_postal INT NOT NULL, UNIQUE INDEX UNIQ_CFF65260E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medcin (id INT AUTO_INCREMENT NOT NULL, nom_complet VARCHAR(30) DEFAULT NULL, username VARCHAR(40) NOT NULL, mdp VARCHAR(255) NOT NULL, type_compte VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, code_postal INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendezvous (rendezvous_id INT AUTO_INCREMENT NOT NULL, parent_id INT NOT NULL, centre_id INT NOT NULL, rendezvous_at DATE NOT NULL, medcine_id INT NOT NULL, PRIMARY KEY(rendezvous_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tuteur (id INT AUTO_INCREMENT NOT NULL, nom_complet VARCHAR(30) DEFAULT NULL, username VARCHAR(40) NOT NULL, mdp VARCHAR(255) NOT NULL, type_compte VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, nom_complet_bebe VARCHAR(255) DEFAULT NULL, date_naissance DATE DEFAULT NULL, code_postal INT DEFAULT NULL, validation INT NOT NULL, id_centre INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE centre');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE medcin');
        $this->addSql('DROP TABLE rendezvous');
        $this->addSql('DROP TABLE tuteur');
    }
}
