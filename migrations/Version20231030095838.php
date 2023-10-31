<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231030095838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products ADD is_public TINYINT(1) NOT NULL, CHANGE boite boite VARCHAR(50) DEFAULT NULL, CHANGE energie energie VARCHAR(50) DEFAULT NULL, CHANGE puissance puissance VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE pseudo pseudo VARCHAR(50) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE products DROP is_public, CHANGE boite boite VARCHAR(50) DEFAULT \'NULL\', CHANGE energie energie VARCHAR(50) DEFAULT \'NULL\', CHANGE puissance puissance VARCHAR(50) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE pseudo pseudo VARCHAR(50) DEFAULT \'NULL\', CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
