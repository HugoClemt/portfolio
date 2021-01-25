<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210122084219 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enseignant_promotion (enseignant_id INT NOT NULL, promotion_id INT NOT NULL, INDEX IDX_19BAFF82E455FCC0 (enseignant_id), INDEX IDX_19BAFF82139DF194 (promotion_id), PRIMARY KEY(enseignant_id, promotion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE enseignant_promotion ADD CONSTRAINT FK_19BAFF82E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enseignant_promotion ADD CONSTRAINT FK_19BAFF82139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY activite_ibfk_1');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B87555155582E9C0 FOREIGN KEY (bloc_id) REFERENCES bloc (id)');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY commentaire_ibfk_1');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY commentaire_ibfk_2');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCE455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCB70FF80C FOREIGN KEY (rp_id) REFERENCES rp (id)');
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY competence_ibfk_1');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY enseignant_ibfk_1');
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY enseignant_ibfk_2');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA1F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE etudiant DROP INDEX user_id, ADD UNIQUE INDEX UNIQ_717E22E3A76ED395 (user_id)');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY etudiant_ibfk_1');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY etudiant_ibfk_2');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY pointage_ibfk_1');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B202298D193');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20122EEC90 FOREIGN KEY (semaine_id) REFERENCES semaine_stage (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B202298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE production DROP FOREIGN KEY production_ibfk_1');
        $this->addSql('ALTER TABLE production ADD CONSTRAINT FK_D3EDB1E0B70FF80C FOREIGN KEY (rp_id) REFERENCES rp (id)');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD12195E0F0');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD12195E0F0 FOREIGN KEY (specialite_id) REFERENCES `Specialite` (id)');
        $this->addSql('ALTER TABLE rp DROP FOREIGN KEY rp_ibfk_1');
        $this->addSql('ALTER TABLE rp DROP FOREIGN KEY rp_ibfk_2');
        $this->addSql('ALTER TABLE rp DROP FOREIGN KEY rp_ibfk_3');
        $this->addSql('ALTER TABLE rp DROP FOREIGN KEY rp_ibfk_4');
        $this->addSql('ALTER TABLE rp DROP FOREIGN KEY rp_ibfk_5');
        $this->addSql('ALTER TABLE rp DROP FOREIGN KEY rp_ibfk_6');
        $this->addSql('ALTER TABLE rp DROP FOREIGN KEY rp_ibfk_7');
        $this->addSql('ALTER TABLE rp ADD CONSTRAINT FK_CD578B7C68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE rp ADD CONSTRAINT FK_CD578B7F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE rp ADD CONSTRAINT FK_CD578B7953C1C61 FOREIGN KEY (source_id) REFERENCES source (id)');
        $this->addSql('ALTER TABLE rp ADD CONSTRAINT FK_CD578B7DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE rp ADD CONSTRAINT FK_CD578B7E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE rp ADD CONSTRAINT FK_CD578B79308DA90 FOREIGN KEY (cadre_id) REFERENCES cadre (id)');
        $this->addSql('ALTER TABLE rp ADD CONSTRAINT FK_CD578B7B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE rpactivite DROP FOREIGN KEY rpactivite_ibfk_2');
        $this->addSql('ALTER TABLE rpactivite DROP FOREIGN KEY rpactivite_ibfk_3');
        $this->addSql('ALTER TABLE rpactivite ADD CONSTRAINT FK_3CC2747A9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE rpactivite ADD CONSTRAINT FK_3CC2747AB70FF80C FOREIGN KEY (rp_id) REFERENCES rp (id)');
        $this->addSql('ALTER TABLE semaine_stage DROP FOREIGN KEY semaine_stage_ibfk_1');
        $this->addSql('ALTER TABLE semaine_stage ADD CONSTRAINT FK_877C1C32298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY stage_ibfk_1');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY stage_ibfk_2');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE tache_semaine DROP FOREIGN KEY tache_semaine_ibfk_1');
        $this->addSql('ALTER TABLE tache_semaine DROP FOREIGN KEY tache_semaine_ibfk_2');
        $this->addSql('ALTER TABLE tache_semaine DROP FOREIGN KEY tache_semaine_ibfk_3');
        $this->addSql('ALTER TABLE tache_semaine ADD CONSTRAINT FK_B11BB55F4272FC9F FOREIGN KEY (domaine_id) REFERENCES domaine_taches (id)');
        $this->addSql('ALTER TABLE tache_semaine ADD CONSTRAINT FK_B11BB55F220C6AD0 FOREIGN KEY (jour_id) REFERENCES jour (id)');
        $this->addSql('ALTER TABLE tache_semaine ADD CONSTRAINT FK_B11BB55FE928EFB1 FOREIGN KEY (semaine_stage_id) REFERENCES semaine_stage (id)');
        $this->addSql('ALTER TABLE user DROP INDEX username, ADD UNIQUE INDEX UNIQ_8D93D649F85E0677 (username)');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE enseignant_promotion');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B87555155582E9C0');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT activite_ibfk_1 FOREIGN KEY (bloc_id) REFERENCES bloc (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCE455FCC0');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCB70FF80C');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT commentaire_ibfk_1 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT commentaire_ibfk_2 FOREIGN KEY (rp_id) REFERENCES rp (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687F9B0F88B1');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT competence_ibfk_1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY FK_81A72FA1F46CD258');
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY FK_81A72FA1A76ED395');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT enseignant_ibfk_1 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT enseignant_ibfk_2 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant DROP INDEX UNIQ_717E22E3A76ED395, ADD INDEX user_id (user_id)');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3139DF194');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3A76ED395');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT etudiant_ibfk_1 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT etudiant_ibfk_2 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B20122EEC90');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B202298D193');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT pointage_ibfk_1 FOREIGN KEY (semaine_id) REFERENCES semaine_stage (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B202298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE production DROP FOREIGN KEY FK_D3EDB1E0B70FF80C');
        $this->addSql('ALTER TABLE production ADD CONSTRAINT production_ibfk_1 FOREIGN KEY (rp_id) REFERENCES rp (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD12195E0F0');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD12195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rp DROP FOREIGN KEY FK_CD578B7C68BE09C');
        $this->addSql('ALTER TABLE rp DROP FOREIGN KEY FK_CD578B7F6203804');
        $this->addSql('ALTER TABLE rp DROP FOREIGN KEY FK_CD578B7953C1C61');
        $this->addSql('ALTER TABLE rp DROP FOREIGN KEY FK_CD578B7DDEAB1A3');
        $this->addSql('ALTER TABLE rp DROP FOREIGN KEY FK_CD578B7E455FCC0');
        $this->addSql('ALTER TABLE rp DROP FOREIGN KEY FK_CD578B79308DA90');
        $this->addSql('ALTER TABLE rp DROP FOREIGN KEY FK_CD578B7B3E9C81');
        $this->addSql('ALTER TABLE rp ADD CONSTRAINT rp_ibfk_1 FOREIGN KEY (localisation_id) REFERENCES localisation (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rp ADD CONSTRAINT rp_ibfk_2 FOREIGN KEY (cadre_id) REFERENCES cadre (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rp ADD CONSTRAINT rp_ibfk_3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rp ADD CONSTRAINT rp_ibfk_4 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rp ADD CONSTRAINT rp_ibfk_5 FOREIGN KEY (source_id) REFERENCES source (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rp ADD CONSTRAINT rp_ibfk_6 FOREIGN KEY (statut_id) REFERENCES statut (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rp ADD CONSTRAINT rp_ibfk_7 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rpactivite DROP FOREIGN KEY FK_3CC2747A9B0F88B1');
        $this->addSql('ALTER TABLE rpactivite DROP FOREIGN KEY FK_3CC2747AB70FF80C');
        $this->addSql('ALTER TABLE rpactivite ADD CONSTRAINT rpactivite_ibfk_2 FOREIGN KEY (activite_id) REFERENCES activite (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rpactivite ADD CONSTRAINT rpactivite_ibfk_3 FOREIGN KEY (rp_id) REFERENCES rp (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE semaine_stage DROP FOREIGN KEY FK_877C1C32298D193');
        $this->addSql('ALTER TABLE semaine_stage ADD CONSTRAINT semaine_stage_ibfk_1 FOREIGN KEY (stage_id) REFERENCES stage (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369DDEAB1A3');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369E455FCC0');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT stage_ibfk_1 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT stage_ibfk_2 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tache_semaine DROP FOREIGN KEY FK_B11BB55F4272FC9F');
        $this->addSql('ALTER TABLE tache_semaine DROP FOREIGN KEY FK_B11BB55F220C6AD0');
        $this->addSql('ALTER TABLE tache_semaine DROP FOREIGN KEY FK_B11BB55FE928EFB1');
        $this->addSql('ALTER TABLE tache_semaine ADD CONSTRAINT tache_semaine_ibfk_1 FOREIGN KEY (domaine_id) REFERENCES domaine_taches (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tache_semaine ADD CONSTRAINT tache_semaine_ibfk_2 FOREIGN KEY (jour_id) REFERENCES jour (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tache_semaine ADD CONSTRAINT tache_semaine_ibfk_3 FOREIGN KEY (semaine_stage_id) REFERENCES semaine_stage (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user DROP INDEX UNIQ_8D93D649F85E0677, ADD INDEX username (username)');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE roles roles VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
    }
}
