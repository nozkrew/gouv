<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200306082411 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE list_exploitation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE list_travaux (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE list_type_bien (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE strategy (id INT AUTO_INCREMENT NOT NULL, price INT NOT NULL, cashflow INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE strategy_list_exploitation (strategy_id INT NOT NULL, list_exploitation_id INT NOT NULL, INDEX IDX_1DB9913AD5CAD932 (strategy_id), INDEX IDX_1DB9913A3A7DFCD8 (list_exploitation_id), PRIMARY KEY(strategy_id, list_exploitation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE strategy_list_type_bien (strategy_id INT NOT NULL, list_type_bien_id INT NOT NULL, INDEX IDX_248C9157D5CAD932 (strategy_id), INDEX IDX_248C9157EF5132E1 (list_type_bien_id), PRIMARY KEY(strategy_id, list_type_bien_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE strategy_list_travaux (strategy_id INT NOT NULL, list_travaux_id INT NOT NULL, INDEX IDX_BBFDE1D6D5CAD932 (strategy_id), INDEX IDX_BBFDE1D64EB8B03E (list_travaux_id), PRIMARY KEY(strategy_id, list_travaux_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE strategy_list_exploitation ADD CONSTRAINT FK_1DB9913AD5CAD932 FOREIGN KEY (strategy_id) REFERENCES strategy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE strategy_list_exploitation ADD CONSTRAINT FK_1DB9913A3A7DFCD8 FOREIGN KEY (list_exploitation_id) REFERENCES list_exploitation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE strategy_list_type_bien ADD CONSTRAINT FK_248C9157D5CAD932 FOREIGN KEY (strategy_id) REFERENCES strategy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE strategy_list_type_bien ADD CONSTRAINT FK_248C9157EF5132E1 FOREIGN KEY (list_type_bien_id) REFERENCES list_type_bien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE strategy_list_travaux ADD CONSTRAINT FK_BBFDE1D6D5CAD932 FOREIGN KEY (strategy_id) REFERENCES strategy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE strategy_list_travaux ADD CONSTRAINT FK_BBFDE1D64EB8B03E FOREIGN KEY (list_travaux_id) REFERENCES list_travaux (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE strategy_list_exploitation DROP FOREIGN KEY FK_1DB9913A3A7DFCD8');
        $this->addSql('ALTER TABLE strategy_list_travaux DROP FOREIGN KEY FK_BBFDE1D64EB8B03E');
        $this->addSql('ALTER TABLE strategy_list_type_bien DROP FOREIGN KEY FK_248C9157EF5132E1');
        $this->addSql('ALTER TABLE strategy_list_exploitation DROP FOREIGN KEY FK_1DB9913AD5CAD932');
        $this->addSql('ALTER TABLE strategy_list_type_bien DROP FOREIGN KEY FK_248C9157D5CAD932');
        $this->addSql('ALTER TABLE strategy_list_travaux DROP FOREIGN KEY FK_BBFDE1D6D5CAD932');
        $this->addSql('DROP TABLE list_exploitation');
        $this->addSql('DROP TABLE list_travaux');
        $this->addSql('DROP TABLE list_type_bien');
        $this->addSql('DROP TABLE strategy');
        $this->addSql('DROP TABLE strategy_list_exploitation');
        $this->addSql('DROP TABLE strategy_list_type_bien');
        $this->addSql('DROP TABLE strategy_list_travaux');
    }
}
