<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200511112220 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE figure DROP video_links');
        $this->addSql('ALTER TABLE link ADD figure_id INT NOT NULL');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F15C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id)');
        $this->addSql('CREATE INDEX IDX_36AC99F15C011B5 ON link (figure_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE figure ADD video_links JSON NOT NULL');
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F15C011B5');
        $this->addSql('DROP INDEX IDX_36AC99F15C011B5 ON link');
        $this->addSql('ALTER TABLE link DROP figure_id');
    }
}
