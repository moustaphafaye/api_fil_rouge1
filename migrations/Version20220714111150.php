<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714111150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD commandezone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D644B23FD FOREIGN KEY (commandezone_id) REFERENCES zone (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D644B23FD ON commande (commandezone_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D644B23FD');
        $this->addSql('DROP INDEX IDX_6EEAA67D644B23FD ON commande');
        $this->addSql('ALTER TABLE commande DROP commandezone_id');
    }
}
