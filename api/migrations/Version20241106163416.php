<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241106163416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id VARCHAR(255) NOT NULL, age INT NOT NULL, ssn VARCHAR(255) NOT NULL, fico INT NOT NULL, email VARCHAR(255) NOT NULL, phone_number JSON NOT NULL, name_first_name VARCHAR(255) NOT NULL, name_last_name VARCHAR(255) NOT NULL, address_city VARCHAR(255) NOT NULL, address_state VARCHAR(255) NOT NULL, address_zip VARCHAR(255) NOT NULL, income_value INT NOT NULL, income_pow INT NOT NULL, income_currency VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product (id VARCHAR(255) NOT NULL, client_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, loan_term INT NOT NULL, interest_rates JSON NOT NULL, status VARCHAR(255) NOT NULL, money_value INT NOT NULL, money_pow INT NOT NULL, money_currency VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE product');
    }
}
