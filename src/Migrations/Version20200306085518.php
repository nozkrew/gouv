<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200306085518 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE strategy ADD travaux_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE strategy ADD CONSTRAINT FK_144645ED9495C4E2 FOREIGN KEY (travaux_id) REFERENCES list_travaux (id)');
        $this->addSql('CREATE INDEX IDX_144645ED9495C4E2 ON strategy (travaux_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE strategy DROP FOREIGN KEY FK_144645ED9495C4E2');
        $this->addSql('DROP INDEX IDX_144645ED9495C4E2 ON strategy');
        $this->addSql('ALTER TABLE strategy DROP travaux_id');
    }
}
