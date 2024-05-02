<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240429064225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cp SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone SMALLINT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE food_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_composition (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_64835D0BCCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opening_days (id INT AUTO_INCREMENT NOT NULL, midi SMALLINT NOT NULL, soir SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictures (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plates (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_range (id INT AUTO_INCREMENT NOT NULL, price_range SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, food_type_id INT DEFAULT NULL, price_range_id INT DEFAULT NULL, city_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, phone SMALLINT NOT NULL, address VARCHAR(255) NOT NULL, notation_total SMALLINT DEFAULT NULL, capacity_max INT NOT NULL, INDEX IDX_EB95123F8AD350AB (food_type_id), INDEX IDX_EB95123F4834EBA6 (price_range_id), INDEX IDX_EB95123F8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_composition ADD CONSTRAINT FK_64835D0BCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F8AD350AB FOREIGN KEY (food_type_id) REFERENCES food_type (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F4834EBA6 FOREIGN KEY (price_range_id) REFERENCES price_range (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_composition DROP FOREIGN KEY FK_64835D0BCCD7E912');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F8AD350AB');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F4834EBA6');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F8BAC62AF');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE food_type');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_composition');
        $this->addSql('DROP TABLE opening_days');
        $this->addSql('DROP TABLE pictures');
        $this->addSql('DROP TABLE plates');
        $this->addSql('DROP TABLE price_range');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
