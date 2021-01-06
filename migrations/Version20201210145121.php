<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201210145121 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pointage (id INT AUTO_INCREMENT NOT NULL, stage_id INT DEFAULT NULL, semaine_id INT DEFAULT NULL, datepoint DATE DEFAULT NULL, heurepoint TIME DEFAULT NULL, ip VARCHAR(255) DEFAULT NULL, INDEX IDX_7591B202298D193 (stage_id), INDEX IDX_7591B20122EEC90 (semaine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE production (id INT AUTO_INCREMENT NOT NULL, rp_id INT DEFAULT NULL, designation VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, INDEX IDX_D3EDB1E0B70FF80C (rp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B202298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20122EEC90 FOREIGN KEY (semaine_id) REFERENCES semaine_stage (id)');
        $this->addSql('ALTER TABLE production ADD CONSTRAINT FK_D3EDB1E0B70FF80C FOREIGN KEY (rp_id) REFERENCES rp (id)');
        $this->addSql('ALTER TABLE stage DROP faxentreprise, CHANGE teltut teltut VARCHAR(15) DEFAULT NULL, CHANGE telentreprise telentreprise VARCHAR(50) DEFAULT NULL, CHANGE hor_lun hor_lun VARCHAR(20) DEFAULT NULL, CHANGE hor_mar hor_mar VARCHAR(20) DEFAULT NULL, CHANGE hor_mer hor_mer VARCHAR(20) DEFAULT NULL, CHANGE hor_jeu hor_jeu VARCHAR(20) DEFAULT NULL, CHANGE hor_ven hor_ven VARCHAR(20) DEFAULT NULL, CHANGE hor_sam hor_sam VARCHAR(20) DEFAULT NULL, CHANGE coordonneestut nomtut VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pointage');
        $this->addSql('DROP TABLE production');
        $this->addSql('ALTER TABLE stage ADD faxentreprise VARCHAR(25) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE teltut teltut INT DEFAULT NULL, CHANGE telentreprise telentreprise INT NOT NULL, CHANGE hor_lun hor_lun INT DEFAULT NULL, CHANGE hor_mar hor_mar INT DEFAULT NULL, CHANGE hor_mer hor_mer INT DEFAULT NULL, CHANGE hor_jeu hor_jeu INT DEFAULT NULL, CHANGE hor_ven hor_ven INT DEFAULT NULL, CHANGE hor_sam hor_sam INT DEFAULT NULL, CHANGE nomtut coordonneestut VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
