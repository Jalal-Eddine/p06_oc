<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211023202405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, trick_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_5F9E962AA76ED395 (user_id), INDEX IDX_5F9E962AB281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AB281BE2E FOREIGN KEY (trick_id) REFERENCES tricks (id)');
        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C12F68B530');
        $this->addSql('DROP INDEX IDX_E1D902C12F68B530 ON tricks');
        $this->addSql('ALTER TABLE tricks CHANGE group_id_id group_id INT NOT NULL');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C1FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_E1D902C1FE54D947 ON tricks (group_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comments');
        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C1FE54D947');
        $this->addSql('DROP INDEX IDX_E1D902C1FE54D947 ON tricks');
        $this->addSql('ALTER TABLE tricks CHANGE group_id group_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C12F68B530 FOREIGN KEY (group_id_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_E1D902C12F68B530 ON tricks (group_id_id)');
    }
}
