<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210114133039 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enseignant RENAME INDEX uniq_81a72fa19d86650f TO UNIQ_81A72FA1A76ED395');
        $this->addSql('ALTER TABLE etudiant RENAME INDEX uniq_717e22e39d86650f TO UNIQ_717E22E3A76ED395');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enseignant RENAME INDEX uniq_81a72fa1a76ed395 TO UNIQ_81A72FA19D86650F');
        $this->addSql('ALTER TABLE etudiant RENAME INDEX uniq_717e22e3a76ed395 TO UNIQ_717E22E39D86650F');
    }
}
