<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220703135543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0DA76ED395');
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0D6885AC1B');
        $this->addSql('DROP INDEX IDX_EFE35A0D6885AC1B ON burger');
        $this->addSql('DROP INDEX IDX_EFE35A0DA76ED395 ON burger');
        $this->addSql('ALTER TABLE burger DROP gestionnaire_id, DROP user_id');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A936885AC1B');
        $this->addSql('DROP INDEX IDX_7D053A936885AC1B ON menu');
        $this->addSql('ALTER TABLE menu DROP gestionnaire_id');
        $this->addSql('ALTER TABLE produit ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC276885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC276885AC1B ON produit (gestionnaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger ADD gestionnaire_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0D6885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_EFE35A0D6885AC1B ON burger (gestionnaire_id)');
        $this->addSql('CREATE INDEX IDX_EFE35A0DA76ED395 ON burger (user_id)');
        $this->addSql('ALTER TABLE menu ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A936885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_7D053A936885AC1B ON menu (gestionnaire_id)');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC276885AC1B');
        $this->addSql('DROP INDEX IDX_29A5EC276885AC1B ON produit');
        $this->addSql('ALTER TABLE produit DROP gestionnaire_id');
    }
}
