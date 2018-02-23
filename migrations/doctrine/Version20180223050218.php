<?php declare(strict_types = 1);

namespace Omed\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180223050218 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE security_groups_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE customers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE employees_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE security_users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE security_groups (id INT NOT NULL, name VARCHAR(180) NOT NULL, roles TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C682CF655E237E06 ON security_groups (name)');
        $this->addSql('COMMENT ON COLUMN security_groups.roles IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE customers (id INT NOT NULL, login_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, type SMALLINT NOT NULL, status SMALLINT NOT NULL, company VARCHAR(255) DEFAULT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62534E215CB2E05D ON customers (login_id)');
        $this->addSql('CREATE TABLE customer_address (customer_id INT NOT NULL, address_id INT NOT NULL, PRIMARY KEY(customer_id, address_id))');
        $this->addSql('CREATE INDEX IDX_1193CB3F9395C3F3 ON customer_address (customer_id)');
        $this->addSql('CREATE INDEX IDX_1193CB3FF5B7AF75 ON customer_address (address_id)');
        $this->addSql('CREATE TABLE address (id INT NOT NULL, address TEXT NOT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, zip VARCHAR(255) DEFAULT NULL, phone VARCHAR(50) DEFAULT NULL, fax VARCHAR(50) DEFAULT NULL, mobile VARCHAR(50) DEFAULT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE employees (id INT NOT NULL, login_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, gender VARCHAR(1) NOT NULL, email VARCHAR(255) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA82C3005CB2E05D ON employees (login_id)');
        $this->addSql('CREATE TABLE employee_address (customer_id INT NOT NULL, address_id INT NOT NULL, PRIMARY KEY(customer_id, address_id))');
        $this->addSql('CREATE INDEX IDX_8D02398E9395C3F3 ON employee_address (customer_id)');
        $this->addSql('CREATE INDEX IDX_8D02398EF5B7AF75 ON employee_address (address_id)');
        $this->addSql('CREATE TABLE security_users (id INT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, roles TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F83F464392FC23A8 ON security_users (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F83F4643A0D96FBF ON security_users (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F83F4643C05FB297 ON security_users (confirmation_token)');
        $this->addSql('COMMENT ON COLUMN security_users.roles IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE customers ADD CONSTRAINT FK_62534E215CB2E05D FOREIGN KEY (login_id) REFERENCES security_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customer_address ADD CONSTRAINT FK_1193CB3F9395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customer_address ADD CONSTRAINT FK_1193CB3FF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employees ADD CONSTRAINT FK_BA82C3005CB2E05D FOREIGN KEY (login_id) REFERENCES security_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employee_address ADD CONSTRAINT FK_8D02398E9395C3F3 FOREIGN KEY (customer_id) REFERENCES employees (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employee_address ADD CONSTRAINT FK_8D02398EF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE customer_address DROP CONSTRAINT FK_1193CB3F9395C3F3');
        $this->addSql('ALTER TABLE customer_address DROP CONSTRAINT FK_1193CB3FF5B7AF75');
        $this->addSql('ALTER TABLE employee_address DROP CONSTRAINT FK_8D02398EF5B7AF75');
        $this->addSql('ALTER TABLE employee_address DROP CONSTRAINT FK_8D02398E9395C3F3');
        $this->addSql('ALTER TABLE customers DROP CONSTRAINT FK_62534E215CB2E05D');
        $this->addSql('ALTER TABLE employees DROP CONSTRAINT FK_BA82C3005CB2E05D');
        $this->addSql('DROP SEQUENCE security_groups_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE customers_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE employees_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE security_users_id_seq CASCADE');
        $this->addSql('DROP TABLE security_groups');
        $this->addSql('DROP TABLE customers');
        $this->addSql('DROP TABLE customer_address');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE employees');
        $this->addSql('DROP TABLE employee_address');
        $this->addSql('DROP TABLE security_users');
    }
}
