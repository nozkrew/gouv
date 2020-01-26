<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200125094950 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE indicator (id INT AUTO_INCREMENT NOT NULL, city_id INT UNSIGNED DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, unity VARCHAR(10) NOT NULL, INDEX IDX_D1349DB38BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE indicator_value (id INT AUTO_INCREMENT NOT NULL, indicator_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_D18506234402854A (indicator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE indicator ADD CONSTRAINT FK_D1349DB38BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id)');
        $this->addSql('ALTER TABLE indicator_value ADD CONSTRAINT FK_D18506234402854A FOREIGN KEY (indicator_id) REFERENCES indicator (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE indicator_value DROP FOREIGN KEY FK_D18506234402854A');
        $this->addSql('DROP TABLE indicator');
        $this->addSql('DROP TABLE indicator_value');
    }
}
