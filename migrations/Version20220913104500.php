<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220913104500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users (
            uuid UUID NOT NULL,
            email VARCHAR(320) NOT NULL,
            username VARCHAR(255) NOT NULL,
            displayName VARCHAR(255) NOT NULL,
            hashedPassword VARCHAR(255) NOT NULL,
            createdAt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            PRIMARY KEY(uuid)
        )');
        $this->addSql('CREATE UNIQUE INDEX email_idx ON users (email)');
        $this->addSql('CREATE UNIQUE INDEX username_idx ON users (username)');
        $this->addSql('COMMENT ON COLUMN users.uuid IS \'(DC2Type:App\\User\\Domain\\ValueObject\\Uuid)\'');
        $this->addSql('COMMENT ON COLUMN users.email IS \'(DC2Type:App\\User\\Infrastructure\\DBAL\\Types\\EmailType)\'');
        $this->addSql('COMMENT ON COLUMN users.username IS \'(DC2Type:App\\User\\Infrastructure\\DBAL\\Types\\UsernameType)\'');
        $this->addSql('COMMENT ON COLUMN users.displayName IS \'(DC2Type:App\\User\\Infrastructure\\DBAL\\Types\\DisplayNameType)\'');
        $this->addSql('COMMENT ON COLUMN users.hashedPassword IS \'(DC2Type:App\\User\\Infrastructure\\DBAL\\Types\\HashedPasswordType)\'');
        $this->addSql('COMMENT ON COLUMN users.createdAt IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE users');
    }
}
