<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211017162524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, trick_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6AB46B9EE8 (trick_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE videos (id INT AUTO_INCREMENT NOT NULL, trick_id_id INT NOT NULL, embed LONGTEXT NOT NULL, INDEX IDX_29AA6432B46B9EE8 (trick_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AB46B9EE8 FOREIGN KEY (trick_id_id) REFERENCES tricks (id)');
        $this->addSql('ALTER TABLE videos ADD CONSTRAINT FK_29AA6432B46B9EE8 FOREIGN KEY (trick_id_id) REFERENCES tricks (id)');
        $this->addSql('ALTER TABLE tricks ADD group_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C12F68B530 FOREIGN KEY (group_id_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_E1D902C12F68B530 ON tricks (group_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C12F68B530');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE videos');
        $this->addSql('DROP INDEX IDX_E1D902C12F68B530 ON tricks');
        $this->addSql('ALTER TABLE tricks DROP group_id_id');
    }
}
