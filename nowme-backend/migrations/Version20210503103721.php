<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210503103721 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service ADD name_id INT DEFAULT NULL, DROP name');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD271179CD6 FOREIGN KEY (name_id) REFERENCES service_dictionary (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD271179CD6 ON service (name_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD271179CD6');
        $this->addSql('DROP INDEX IDX_E19D9AD271179CD6 ON service');
        $this->addSql('ALTER TABLE service ADD name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP name_id');
    }
}
