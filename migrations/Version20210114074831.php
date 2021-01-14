<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210114074831 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) DEFAULT NULL, copos VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE ens_promo');
        $this->addSql('ALTER TABLE domaine_taches DROP FOREIGN KEY domaine_taches_ibfk_1');
        $this->addSql('DROP INDEX IDX_341B7CB63ADB05F1 ON domaine_taches');
        $this->addSql('ALTER TABLE domaine_taches DROP options_id');
        $this->addSql('ALTER TABLE etudiant CHANGE ville ville VARCHAR(255) NOT NULL, CHANGE copos copos VARCHAR(6) NOT NULL');
        $this->addSql('ALTER TABLE pointage CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B202298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE pointage RENAME INDEX fk_point_stage TO IDX_7591B202298D193');
        $this->addSql('ALTER TABLE pointage RENAME INDEX fk_point_semaine TO IDX_7591B20122EEC90');
        $this->addSql('ALTER TABLE production CHANGE rp_id rp_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE production RENAME INDEX fk_prod_rp TO IDX_D3EDB1E0B70FF80C');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY promotion_ibfk_1');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD12195E0F0 FOREIGN KEY (specialite_id) REFERENCES `Specialite` (id)');
        $this->addSql('ALTER TABLE promotion RENAME INDEX specialite_id TO IDX_C11D7DD12195E0F0');
        $this->addSql('ALTER TABLE rp DROP archivage, CHANGE niveau_id niveau_id INT DEFAULT NULL, CHANGE besoin besoin VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE rp RENAME INDEX niveau_id TO IDX_CD578B7B3E9C81');
        $this->addSql('ALTER TABLE stage CHANGE nomtut nomtut VARCHAR(20) DEFAULT NULL, CHANGE teltut teltut VARCHAR(10) DEFAULT NULL, CHANGE nomentreprise nomentreprise VARCHAR(255) DEFAULT NULL, CHANGE copos copos VARCHAR(5) DEFAULT NULL, CHANGE siret siret VARCHAR(14) DEFAULT NULL, CHANGE telentreprise telentreprise VARCHAR(10) DEFAULT NULL, CHANGE sujet sujet VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE stage RENAME INDEX idx_c27c9369a873a5c6 TO IDX_C27C9369DDEAB1A3');
        $this->addSql('ALTER TABLE stage RENAME INDEX idx_c27c93697cf12a69 TO IDX_C27C9369E455FCC0');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ens_promo (ens_id INT NOT NULL, promo_id INT NOT NULL, INDEX enseignant_promo (ens_id), INDEX promo_enseignant (promo_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ens_promo ADD CONSTRAINT ens_promo_ibfk_1 FOREIGN KEY (ens_id) REFERENCES enseignant (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE ens_promo ADD CONSTRAINT ens_promo_ibfk_2 FOREIGN KEY (promo_id) REFERENCES promotion (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE ville');
        $this->addSql('ALTER TABLE domaine_taches ADD options_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE domaine_taches ADD CONSTRAINT domaine_taches_ibfk_1 FOREIGN KEY (options_id) REFERENCES specialite (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_341B7CB63ADB05F1 ON domaine_taches (options_id)');
        $this->addSql('ALTER TABLE etudiant CHANGE ville ville VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE copos copos VARCHAR(6) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B202298D193');
        $this->addSql('ALTER TABLE pointage CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE pointage RENAME INDEX idx_7591b20122eec90 TO FK_point_semaine');
        $this->addSql('ALTER TABLE pointage RENAME INDEX idx_7591b202298d193 TO FK_point_stage');
        $this->addSql('ALTER TABLE production CHANGE rp_id rp_id INT NOT NULL');
        $this->addSql('ALTER TABLE production RENAME INDEX idx_d3edb1e0b70ff80c TO FK_prod_rp');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD12195E0F0');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT promotion_ibfk_1 FOREIGN KEY (specialite_id) REFERENCES specialite (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion RENAME INDEX idx_c11d7dd12195e0f0 TO specialite_id');
        $this->addSql('ALTER TABLE rp ADD archivage TINYINT(1) NOT NULL, CHANGE niveau_id niveau_id INT NOT NULL, CHANGE besoin besoin VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE rp RENAME INDEX idx_cd578b7b3e9c81 TO niveau_id');
        $this->addSql('ALTER TABLE stage CHANGE nomtut nomtut VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE teltut teltut VARCHAR(15) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nomentreprise nomentreprise VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE copos copos VARCHAR(6) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE siret siret VARCHAR(15) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telentreprise telentreprise VARCHAR(15) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE sujet sujet VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE stage RENAME INDEX idx_c27c9369e455fcc0 TO IDX_C27C93697CF12A69');
        $this->addSql('ALTER TABLE stage RENAME INDEX idx_c27c9369ddeab1a3 TO IDX_C27C9369A873A5C6');
    }
}
