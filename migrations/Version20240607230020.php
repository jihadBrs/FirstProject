<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240607230020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FF675F31B');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FBCF5E72D');
        $this->addSql('DROP INDEX IDX_CB988C6FF675F31B ON annonces');
        $this->addSql('DROP INDEX IDX_CB988C6FBCF5E72D ON annonces');
        $this->addSql('ALTER TABLE annonces ADD updated_at DATETIME DEFAULT NULL, DROP author_id, DROP categorie_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces ADD author_id INT DEFAULT NULL, ADD categorie_id INT NOT NULL, DROP updated_at');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_CB988C6FF675F31B ON annonces (author_id)');
        $this->addSql('CREATE INDEX IDX_CB988C6FBCF5E72D ON annonces (categorie_id)');
    }
}
