<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518073202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certification (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, periode_suivi VARCHAR(255) DEFAULT NULL, objectif VARCHAR(255) DEFAULT NULL, analyse VARCHAR(255) DEFAULT NULL, resultal VARCHAR(255) DEFAULT NULL, INDEX IDX_6C3C6D75DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE certification ADD CONSTRAINT FK_6C3C6D75DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('DROP TABLE type');
    }

}
