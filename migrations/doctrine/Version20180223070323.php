<?php declare(strict_types = 1);

namespace Omed\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180223070323 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP INDEX uniq_f83f464392fc23a8');
        $this->addSql('ALTER TABLE security_users ALTER username DROP NOT NULL');
        $this->addSql('ALTER TABLE security_users ALTER username_canonical DROP NOT NULL');
        $this->addSql('ALTER TABLE security_users ALTER password DROP NOT NULL');
        $this->addSql('ALTER TABLE employees ADD hire_date TIMESTAMP(0) WITHOUT TIME ZONE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE security_users ALTER username SET NOT NULL');
        $this->addSql('ALTER TABLE security_users ALTER username_canonical SET NOT NULL');
        $this->addSql('ALTER TABLE security_users ALTER password SET NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX uniq_f83f464392fc23a8 ON security_users (username_canonical)');

        $this->addSql('CREATE SCHEMA IF NOT EXISTS public');
        $this->addSql('ALTER TABLE employees DROP hire_date');
    }
}
