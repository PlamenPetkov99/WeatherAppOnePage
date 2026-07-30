<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260730082417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD temperature_unit VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD wind_speed_unit VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD time_format VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" DROP temperature_unit');
        $this->addSql('ALTER TABLE "user" DROP wind_speed_unit');
        $this->addSql('ALTER TABLE "user" DROP time_format');
    }
}
