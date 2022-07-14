<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714083134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_boisson ADD boisson_id INT DEFAULT NULL, ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_boisson ADD CONSTRAINT FK_7D2CBAED734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id)');
        $this->addSql('ALTER TABLE commande_boisson ADD CONSTRAINT FK_7D2CBAED82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_7D2CBAED734B8089 ON commande_boisson (boisson_id)');
        $this->addSql('CREATE INDEX IDX_7D2CBAED82EA2E54 ON commande_boisson (commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_boisson DROP FOREIGN KEY FK_7D2CBAED734B8089');
        $this->addSql('ALTER TABLE commande_boisson DROP FOREIGN KEY FK_7D2CBAED82EA2E54');
        $this->addSql('DROP INDEX IDX_7D2CBAED734B8089 ON commande_boisson');
        $this->addSql('DROP INDEX IDX_7D2CBAED82EA2E54 ON commande_boisson');
        $this->addSql('ALTER TABLE commande_boisson DROP boisson_id, DROP commande_id');
    }
}
