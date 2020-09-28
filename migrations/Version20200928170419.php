<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200928170419 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_admin_right (app_admin_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', right_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_4D05A8526CABE2BD (app_admin_id), INDEX IDX_4D05A85254976835 (right_id), PRIMARY KEY(app_admin_id, right_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_right (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', right_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_14E08EEED61617DB (right_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_admin_right ADD CONSTRAINT FK_4D05A8526CABE2BD FOREIGN KEY (app_admin_id) REFERENCES app_admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE app_admin_right ADD CONSTRAINT FK_4D05A85254976835 FOREIGN KEY (right_id) REFERENCES admin_right (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_admin_right DROP FOREIGN KEY FK_4D05A85254976835');
        $this->addSql('DROP TABLE app_admin_right');
        $this->addSql('DROP TABLE admin_right');
    }
}
