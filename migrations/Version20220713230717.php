<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713230717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande_taille (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, taille_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_740470ED82EA2E54 (commande_id), INDEX IDX_740470EDFF25611A (taille_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_taille ADD CONSTRAINT FK_740470ED82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE commande_taille ADD CONSTRAINT FK_740470EDFF25611A FOREIGN KEY (taille_id) REFERENCES taille (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commande_taille');
    }
}
