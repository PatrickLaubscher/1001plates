<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240501203313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499395C3F3');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B1E7706E');
        $this->addSql('DROP INDEX UNIQ_8D93D6499395C3F3 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649B1E7706E ON user');
        $this->addSql('ALTER TABLE user DROP restaurant_id, DROP customer_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD restaurant_id INT DEFAULT NULL, ADD customer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6499395C3F3 ON user (customer_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649B1E7706E ON user (restaurant_id)');
    }
}
