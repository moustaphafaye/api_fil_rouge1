<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713232201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_frite ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_frite ADD CONSTRAINT FK_19831BAE82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_19831BAE82EA2E54 ON commande_frite (commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_frite DROP FOREIGN KEY FK_19831BAE82EA2E54');
        $this->addSql('DROP INDEX IDX_19831BAE82EA2E54 ON commande_frite');
        $this->addSql('ALTER TABLE commande_frite DROP commande_id');
    }
}
