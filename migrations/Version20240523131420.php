<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240523131420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93B1E7706E');
        $this->addSql('DROP INDEX IDX_7D053A93B1E7706E ON menu');
        $this->addSql('ALTER TABLE menu DROP restaurant_id');
        $this->addSql('ALTER TABLE opening_days DROP FOREIGN KEY FK_D613A4DB1E7706E');
        $this->addSql('DROP INDEX UNIQ_D613A4DB1E7706E ON opening_days');
        $this->addSql('ALTER TABLE opening_days DROP restaurant_id');
        $this->addSql('ALTER TABLE pictures DROP FOREIGN KEY FK_8F7C2FC0B1E7706E');
        $this->addSql('DROP INDEX IDX_8F7C2FC0B1E7706E ON pictures');
        $this->addSql('ALTER TABLE pictures DROP restaurant_id');
        $this->addSql('ALTER TABLE plates DROP FOREIGN KEY FK_E7C6D9A0B1E7706E');
        $this->addSql('DROP INDEX IDX_E7C6D9A0B1E7706E ON plates');
        $this->addSql('ALTER TABLE plates DROP restaurant_id');
        $this->addSql('ALTER TABLE restaurant DROP user_id, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD discr VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE opening_days ADD restaurant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE opening_days ADD CONSTRAINT FK_D613A4DB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D613A4DB1E7706E ON opening_days (restaurant_id)');
        $this->addSql('ALTER TABLE menu ADD restaurant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_7D053A93B1E7706E ON menu (restaurant_id)');
        $this->addSql('ALTER TABLE plates ADD restaurant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plates ADD CONSTRAINT FK_E7C6D9A0B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E7C6D9A0B1E7706E ON plates (restaurant_id)');
        $this->addSql('ALTER TABLE pictures ADD restaurant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_8F7C2FC0B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8F7C2FC0B1E7706E ON pictures (restaurant_id)');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FBF396750');
        $this->addSql('ALTER TABLE restaurant ADD user_id INT NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user DROP discr');
    }
}
