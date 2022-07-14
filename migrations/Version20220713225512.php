<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713225512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_burger ADD commande_id INT DEFAULT NULL, ADD burger_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_burger ADD CONSTRAINT FK_EDB7A1D882EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE commande_burger ADD CONSTRAINT FK_EDB7A1D817CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id)');
        $this->addSql('CREATE INDEX IDX_EDB7A1D882EA2E54 ON commande_burger (commande_id)');
        $this->addSql('CREATE INDEX IDX_EDB7A1D817CE5090 ON commande_burger (burger_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_burger DROP FOREIGN KEY FK_EDB7A1D882EA2E54');
        $this->addSql('ALTER TABLE commande_burger DROP FOREIGN KEY FK_EDB7A1D817CE5090');
        $this->addSql('DROP INDEX IDX_EDB7A1D882EA2E54 ON commande_burger');
        $this->addSql('DROP INDEX IDX_EDB7A1D817CE5090 ON commande_burger');
        $this->addSql('ALTER TABLE commande_burger DROP commande_id, DROP burger_id');
    }
}
