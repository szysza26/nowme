<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210416193424 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE service_office');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2429D30DF');
        $this->addSql('DROP INDEX IDX_E19D9AD2429D30DF ON service');
        $this->addSql('ALTER TABLE service DROP specjalist_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_office (service_id INT NOT NULL, office_id INT NOT NULL, INDEX IDX_4A966E34ED5CA9E6 (service_id), INDEX IDX_4A966E34FFA0C224 (office_id), PRIMARY KEY(service_id, office_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE service_office ADD CONSTRAINT FK_4A966E34ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_office ADD CONSTRAINT FK_4A966E34FFA0C224 FOREIGN KEY (office_id) REFERENCES office (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service ADD specjalist_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2429D30DF FOREIGN KEY (specjalist_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E19D9AD2429D30DF ON service (specjalist_id)');
    }
}
