<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713232446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_frite ADD portion_frite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_frite ADD CONSTRAINT FK_19831BAE9B17FA7B FOREIGN KEY (portion_frite_id) REFERENCES portion_frite (id)');
        $this->addSql('CREATE INDEX IDX_19831BAE9B17FA7B ON commande_frite (portion_frite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_frite DROP FOREIGN KEY FK_19831BAE9B17FA7B');
        $this->addSql('DROP INDEX IDX_19831BAE9B17FA7B ON commande_frite');
        $this->addSql('ALTER TABLE commande_frite DROP portion_frite_id');
    }
}
