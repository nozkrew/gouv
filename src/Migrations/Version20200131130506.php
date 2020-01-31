<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200131130506 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE cities_search');
        $this->addSql('DROP TABLE cities_user');
        $this->addSql('ALTER TABLE search ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE search ADD CONSTRAINT FK_B4F0DBA7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_B4F0DBA7A76ED395 ON search (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cities_search (cities_id INT UNSIGNED NOT NULL, search_id INT NOT NULL, INDEX IDX_8E3B1982CAC75398 (cities_id), INDEX IDX_8E3B1982650760A9 (search_id), PRIMARY KEY(cities_id, search_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE cities_user (cities_id INT UNSIGNED NOT NULL, user_id INT NOT NULL, INDEX IDX_AF040A44CAC75398 (cities_id), INDEX IDX_AF040A44A76ED395 (user_id), PRIMARY KEY(cities_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cities_search ADD CONSTRAINT FK_8E3B1982650760A9 FOREIGN KEY (search_id) REFERENCES search (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cities_search ADD CONSTRAINT FK_8E3B1982CAC75398 FOREIGN KEY (cities_id) REFERENCES cities (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cities_user ADD CONSTRAINT FK_AF040A44A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cities_user ADD CONSTRAINT FK_AF040A44CAC75398 FOREIGN KEY (cities_id) REFERENCES cities (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE search DROP FOREIGN KEY FK_B4F0DBA7A76ED395');
        $this->addSql('DROP INDEX IDX_B4F0DBA7A76ED395 ON search');
        $this->addSql('ALTER TABLE search DROP user_id');
    }
}
