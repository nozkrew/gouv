<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200131081417 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cities_search (cities_id INT UNSIGNED NOT NULL, search_id INT NOT NULL, INDEX IDX_8E3B1982CAC75398 (cities_id), INDEX IDX_8E3B1982650760A9 (search_id), PRIMARY KEY(cities_id, search_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE search (id INT AUTO_INCREMENT NOT NULL, price_max INT NOT NULL, surface_min INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE search_cities (search_id INT NOT NULL, cities_id INT UNSIGNED NOT NULL, INDEX IDX_BFDE74650760A9 (search_id), INDEX IDX_BFDE74CAC75398 (cities_id), PRIMARY KEY(search_id, cities_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cities_search ADD CONSTRAINT FK_8E3B1982CAC75398 FOREIGN KEY (cities_id) REFERENCES cities (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cities_search ADD CONSTRAINT FK_8E3B1982650760A9 FOREIGN KEY (search_id) REFERENCES search (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE search_cities ADD CONSTRAINT FK_BFDE74650760A9 FOREIGN KEY (search_id) REFERENCES search (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE search_cities ADD CONSTRAINT FK_BFDE74CAC75398 FOREIGN KEY (cities_id) REFERENCES cities (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE cities_user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cities_search DROP FOREIGN KEY FK_8E3B1982650760A9');
        $this->addSql('ALTER TABLE search_cities DROP FOREIGN KEY FK_BFDE74650760A9');
        $this->addSql('CREATE TABLE cities_user (cities_id INT UNSIGNED NOT NULL, user_id INT NOT NULL, INDEX IDX_AF040A44CAC75398 (cities_id), INDEX IDX_AF040A44A76ED395 (user_id), PRIMARY KEY(cities_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cities_user ADD CONSTRAINT FK_AF040A44A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cities_user ADD CONSTRAINT FK_AF040A44CAC75398 FOREIGN KEY (cities_id) REFERENCES cities (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE cities_search');
        $this->addSql('DROP TABLE search');
        $this->addSql('DROP TABLE search_cities');
    }
}
