<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200204094033 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE figure ADD figures_group_id INT NOT NULL, ADD date_creation DATETIME NOT NULL, ADD date_last_modification DATETIME NOT NULL');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37A3EFD84C7 FOREIGN KEY (figures_group_id) REFERENCES figures_group (id)');
        $this->addSql('CREATE INDEX IDX_2F57B37A3EFD84C7 ON figure (figures_group_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37A3EFD84C7');
        $this->addSql('DROP INDEX IDX_2F57B37A3EFD84C7 ON figure');
        $this->addSql('ALTER TABLE figure DROP figures_group_id, DROP date_creation, DROP date_last_modification');
    }
}
