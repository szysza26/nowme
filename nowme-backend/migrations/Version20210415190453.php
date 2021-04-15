<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415190453 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, specjalist_id INT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, duration INT NOT NULL, INDEX IDX_E19D9AD2429D30DF (specjalist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_office (service_id INT NOT NULL, office_id INT NOT NULL, INDEX IDX_4A966E34ED5CA9E6 (service_id), INDEX IDX_4A966E34FFA0C224 (office_id), PRIMARY KEY(service_id, office_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2429D30DF FOREIGN KEY (specjalist_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service_office ADD CONSTRAINT FK_4A966E34ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_office ADD CONSTRAINT FK_4A966E34FFA0C224 FOREIGN KEY (office_id) REFERENCES office (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_office DROP FOREIGN KEY FK_4A966E34ED5CA9E6');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_office');
    }
}
