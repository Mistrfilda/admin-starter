<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200927234847 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_admin_app_admin_role (app_admin_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', app_admin_role_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_19331D056CABE2BD (app_admin_id), INDEX IDX_19331D0588429D89 (app_admin_role_id), PRIMARY KEY(app_admin_id, app_admin_role_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_admin_app_admin_role ADD CONSTRAINT FK_19331D056CABE2BD FOREIGN KEY (app_admin_id) REFERENCES app_admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE app_admin_app_admin_role ADD CONSTRAINT FK_19331D0588429D89 FOREIGN KEY (app_admin_role_id) REFERENCES app_admin_role (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE app_admin_app_admin_role');
    }
}
