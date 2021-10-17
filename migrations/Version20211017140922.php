<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211017140922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tricks ADD user_id_id INT NOT NULL, ADD creation_date DATETIME NOT NULL, ADD modification_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C19D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E1D902C19D86650F ON tricks (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C19D86650F');
        $this->addSql('DROP INDEX IDX_E1D902C19D86650F ON tricks');
        $this->addSql('ALTER TABLE tricks DROP user_id_id, DROP creation_date, DROP modification_date');
    }
}
