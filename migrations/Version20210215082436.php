<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210215082436 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE semaine_stage ADD CONSTRAINT FK_877C1C32298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369DDEAB1A3');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369E455FCC0');
        $this->addSql('ALTER TABLE stage CHANGE telentreprise telentreprise VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE tache_semaine DROP FOREIGN KEY FK_B11BB55F220C6AD0');
        $this->addSql('ALTER TABLE tache_semaine DROP FOREIGN KEY FK_B11BB55F4272FC9F');
        $this->addSql('ALTER TABLE tache_semaine DROP FOREIGN KEY FK_B11BB55FE928EFB1');
        $this->addSql('ALTER TABLE tache_semaine ADD CONSTRAINT FK_B11BB55F220C6AD0 FOREIGN KEY (jour_id) REFERENCES jour (id)');
        $this->addSql('ALTER TABLE tache_semaine ADD CONSTRAINT FK_B11BB55F4272FC9F FOREIGN KEY (domaine_id) REFERENCES domaine_taches (id)');
        $this->addSql('ALTER TABLE tache_semaine ADD CONSTRAINT FK_B11BB55FE928EFB1 FOREIGN KEY (semaine_stage_id) REFERENCES semaine_stage (id)');
        $this->addSql('ALTER TABLE user ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649C54C8C93 ON user (type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C54C8C93');
        $this->addSql('DROP TABLE type');
        $this->addSql('ALTER TABLE semaine_stage DROP FOREIGN KEY FK_877C1C32298D193');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369DDEAB1A3');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369E455FCC0');
        $this->addSql('ALTER TABLE stage CHANGE telentreprise telentreprise VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tache_semaine DROP FOREIGN KEY FK_B11BB55F4272FC9F');
        $this->addSql('ALTER TABLE tache_semaine DROP FOREIGN KEY FK_B11BB55F220C6AD0');
        $this->addSql('ALTER TABLE tache_semaine DROP FOREIGN KEY FK_B11BB55FE928EFB1');
        $this->addSql('ALTER TABLE tache_semaine ADD CONSTRAINT FK_B11BB55F4272FC9F FOREIGN KEY (domaine_id) REFERENCES domaine_taches (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tache_semaine ADD CONSTRAINT FK_B11BB55F220C6AD0 FOREIGN KEY (jour_id) REFERENCES jour (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tache_semaine ADD CONSTRAINT FK_B11BB55FE928EFB1 FOREIGN KEY (semaine_stage_id) REFERENCES semaine_stage (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP INDEX IDX_8D93D649C54C8C93 ON user');
        $this->addSql('ALTER TABLE user DROP type_id');
    }
}
