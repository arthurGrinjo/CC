<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250907111752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (name VARCHAR(180) NOT NULL, id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_AC74095AD17F50A6 (uuid), INDEX IDX_AC74095AA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE article (title VARCHAR(180) NOT NULL, text LONGTEXT NOT NULL, id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL, UNIQUE INDEX UNIQ_23A0E66D17F50A6 (uuid), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE club (name VARCHAR(180) NOT NULL, id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL, UNIQUE INDEX UNIQ_B8EE3872D17F50A6 (uuid), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE comment (comment TINYTEXT NOT NULL, related_entity VARCHAR(25) NOT NULL, id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL, commenter_id INT NOT NULL, related_id INT NOT NULL, UNIQUE INDEX UNIQ_9474526CD17F50A6 (uuid), INDEX IDX_9474526CB4D5A9E2 (commenter_id), INDEX IDX_9474526C4162C001 (related_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE event (name VARCHAR(180) NOT NULL, id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL, UNIQUE INDEX UNIQ_3BAE0AA7D17F50A6 (uuid), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE gear (name VARCHAR(180) NOT NULL, id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL, owner_id INT NOT NULL, UNIQUE INDEX UNIQ_B44539BD17F50A6 (uuid), INDEX IDX_B44539B7E3C61F9 (owner_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL, club_id INT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_70E4FA78D17F50A6 (uuid), INDEX IDX_70E4FA7861190A32 (club_id), INDEX IDX_70E4FA78A76ED395 (user_id), UNIQUE INDEX member (club_id, user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE participant (role VARCHAR(20) NOT NULL, id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL, user_id INT NOT NULL, event_id INT NOT NULL, UNIQUE INDEX UNIQ_D79F6B11D17F50A6 (uuid), INDEX IDX_D79F6B11A76ED395 (user_id), INDEX IDX_D79F6B1171F7E88B (event_id), UNIQUE INDEX participant (event_id, user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE route (name VARCHAR(180) NOT NULL, id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL, UNIQUE INDEX UNIQ_2C42079D17F50A6 (uuid), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (email VARCHAR(180) NOT NULL, password VARCHAR(64) NOT NULL, first_name VARCHAR(60) DEFAULT NULL, last_name VARCHAR(60) DEFAULT NULL, roles JSON NOT NULL, id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649D17F50A6 (uuid), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CB4D5A9E2 FOREIGN KEY (commenter_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4162C001 FOREIGN KEY (related_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gear ADD CONSTRAINT FK_B44539B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA7861190A32 FOREIGN KEY (club_id) REFERENCES club (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B1171F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CB4D5A9E2');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4162C001');
        $this->addSql('ALTER TABLE gear DROP FOREIGN KEY FK_B44539B7E3C61F9');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA7861190A32');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA78A76ED395');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11A76ED395');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B1171F7E88B');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE gear');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE route');
        $this->addSql('DROP TABLE user');
    }
}
