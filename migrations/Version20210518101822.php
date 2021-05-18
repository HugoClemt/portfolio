<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518101822 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE echange CHANGE message message LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE etudiant DROP sexe, CHANGE mobile mobile VARCHAR(10) DEFAULT NULL, CHANGE datenaiss datenaiss DATE DEFAULT NULL, CHANGE adrperso adrperso VARCHAR(80) DEFAULT NULL, CHANGE ville ville VARCHAR(255) DEFAULT NULL, CHANGE copos copos VARCHAR(6) DEFAULT NULL');
        $this->addSql('ALTER TABLE semaine_stage CHANGE apprentissage apprentissage VARCHAR(255) NOT NULL, CHANGE bilan bilan VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE stage CHANGE telentreprise telentreprise VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP email');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE echange CHANGE message message LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE etudiant ADD sexe VARCHAR(2) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mobile mobile VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE datenaiss datenaiss DATE NOT NULL, CHANGE adrperso adrperso VARCHAR(80) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ville ville VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE copos copos VARCHAR(6) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE semaine_stage CHANGE apprentissage apprentissage VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE bilan bilan VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE stage CHANGE telentreprise telentreprise VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user ADD email VARCHAR(180) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`');
    }
}
