<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240720145023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clocking_project ADD clocking_id INT NOT NULL');
        $this->addSql('ALTER TABLE clocking_project ADD CONSTRAINT FK_29254587166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE clocking_project ADD CONSTRAINT FK_29254587B6D103F FOREIGN KEY (clocking_id) REFERENCES clocking (id)');
        $this->addSql('CREATE INDEX IDX_29254587B6D103F ON clocking_project (clocking_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clocking_project DROP FOREIGN KEY FK_29254587166D1F9C');
        $this->addSql('ALTER TABLE clocking_project DROP FOREIGN KEY FK_29254587B6D103F');
        $this->addSql('DROP INDEX IDX_29254587B6D103F ON clocking_project');
        $this->addSql('ALTER TABLE clocking_project DROP clocking_id');
    }
}
