<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250823072617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gear (name TINYTEXT NOT NULL, id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL, owner_id INT NOT NULL, UNIQUE INDEX UNIQ_B44539BD17F50A6 (uuid), INDEX IDX_B44539B7E3C61F9 (owner_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE route (name TINYTEXT NOT NULL, id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL, UNIQUE INDEX UNIQ_2C42079D17F50A6 (uuid), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE gear ADD CONSTRAINT FK_B44539B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gear DROP FOREIGN KEY FK_B44539B7E3C61F9');
        $this->addSql('DROP TABLE gear');
        $this->addSql('DROP TABLE route');
    }
}
