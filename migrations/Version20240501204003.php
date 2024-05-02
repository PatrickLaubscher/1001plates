<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240501204003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09A76ED395 ON customer (user_id)');
        $this->addSql('ALTER TABLE restaurant ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB95123FA76ED395 ON restaurant (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FA76ED395');
        $this->addSql('DROP INDEX UNIQ_EB95123FA76ED395 ON restaurant');
        $this->addSql('ALTER TABLE restaurant DROP user_id');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09A76ED395');
        $this->addSql('DROP INDEX UNIQ_81398E09A76ED395 ON customer');
        $this->addSql('ALTER TABLE customer DROP user_id');
    }
}
