<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241128134023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id SERIAL NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, age INT NOT NULL, credit_score INT NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, address_street VARCHAR(255) NOT NULL, address_city VARCHAR(255) NOT NULL, address_state VARCHAR(2) NOT NULL, address_zip VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE credit (id SERIAL NOT NULL, client_id INT DEFAULT NULL, product_name VARCHAR(255) NOT NULL, loan_term INT NOT NULL, interest_rate INT NOT NULL, amount INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1CC16EFE19EB6921 ON credit (client_id)');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFE19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE credit DROP CONSTRAINT FK_1CC16EFE19EB6921');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE credit');
    }
}
