<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714105521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_taille_boisson ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_taille_boisson ADD CONSTRAINT FK_9CA1CDB282EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_9CA1CDB282EA2E54 ON commande_taille_boisson (commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_taille_boisson DROP FOREIGN KEY FK_9CA1CDB282EA2E54');
        $this->addSql('DROP INDEX IDX_9CA1CDB282EA2E54 ON commande_taille_boisson');
        $this->addSql('ALTER TABLE commande_taille_boisson DROP commande_id');
    }
}
