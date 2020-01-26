<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200125122950 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE indicator_value (id INT AUTO_INCREMENT NOT NULL, city_id INT UNSIGNED DEFAULT NULL, indicator_id INT DEFAULT NULL, tab_data LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_D18506238BAC62AF (city_id), INDEX IDX_D18506234402854A (indicator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE indicator_value ADD CONSTRAINT FK_D18506238BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id)');
        $this->addSql('ALTER TABLE indicator_value ADD CONSTRAINT FK_D18506234402854A FOREIGN KEY (indicator_id) REFERENCES indicator (id)');
        $this->addSql('ALTER TABLE indicator DROP FOREIGN KEY FK_D1349DB38BAC62AF');
        $this->addSql('DROP INDEX IDX_D1349DB38BAC62AF ON indicator');
        $this->addSql('ALTER TABLE indicator ADD code VARCHAR(10) NOT NULL, DROP city_id, DROP tab_data');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE indicator_value');
        $this->addSql('ALTER TABLE indicator ADD city_id INT UNSIGNED DEFAULT NULL, ADD tab_data LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', DROP code');
        $this->addSql('ALTER TABLE indicator ADD CONSTRAINT FK_D1349DB38BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id)');
        $this->addSql('CREATE INDEX IDX_D1349DB38BAC62AF ON indicator (city_id)');
    }
}
