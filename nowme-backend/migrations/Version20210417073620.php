<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210417073620 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service ADD specialist_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD27B100C1A FOREIGN KEY (specialist_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD27B100C1A ON service (specialist_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD27B100C1A');
        $this->addSql('DROP INDEX IDX_E19D9AD27B100C1A ON service');
        $this->addSql('ALTER TABLE service DROP specialist_id');
    }
}
