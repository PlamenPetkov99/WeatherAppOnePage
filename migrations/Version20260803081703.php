<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260803081703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

        $this->addSql('ALTER TABLE "user" ADD backup_codes JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {

        $this->addSql('CREATE UNIQUE INDEX unique_user_saved_city ON t_saved_city (user_id_id, city_name, country_name)');
        $this->addSql('ALTER TABLE "user" DROP backup_codes');
    }
}
