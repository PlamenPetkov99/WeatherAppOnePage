<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260730110326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE t_saved_city (id UUID NOT NULL, city_name VARCHAR(255) NOT NULL, country_name VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_id_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_7731CD519D86650F ON t_saved_city (user_id_id)');
        $this->addSql('ALTER TABLE t_saved_city ADD CONSTRAINT FK_7731CD519D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE t_saved_city ADD CONSTRAINT unique_user_saved_city UNIQUE (user_id_id, city_name, country_name)'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE t_saved_city DROP CONSTRAINT FK_7731CD519D86650F');
        $this->addSql('DROP TABLE t_saved_city');
    }
}
