<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250903143345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (name TINYTEXT NOT NULL, id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_AC74095AD17F50A6 (uuid), INDEX IDX_AC74095AA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE club (name TINYTEXT NOT NULL, id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL, UNIQUE INDEX UNIQ_B8EE3872D17F50A6 (uuid), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL, club_id INT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_70E4FA78D17F50A6 (uuid), INDEX IDX_70E4FA7861190A32 (club_id), INDEX IDX_70E4FA78A76ED395 (user_id), UNIQUE INDEX member (club_id, user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA7861190A32 FOREIGN KEY (club_id) REFERENCES club (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AA76ED395');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA7861190A32');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA78A76ED395');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE member');
    }
}
