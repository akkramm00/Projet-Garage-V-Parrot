<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023165749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arrivages (id INT AUTO_INCREMENT NOT NULL, marque VARCHAR(50) NOT NULL, model VARCHAR(50) NOT NULL, property VARCHAR(255) NOT NULL, boite VARCHAR(50) NOT NULL, energie VARCHAR(50) NOT NULL, puissance VARCHAR(50) NOT NULL, is_availlable TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products CHANGE boite boite VARCHAR(50) DEFAULT NULL, CHANGE energie energie VARCHAR(50) DEFAULT NULL, CHANGE puissance puissance VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE arrivages');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE products CHANGE boite boite VARCHAR(50) DEFAULT \'NULL\', CHANGE energie energie VARCHAR(50) DEFAULT \'NULL\', CHANGE puissance puissance VARCHAR(50) DEFAULT \'NULL\'');
    }
}
