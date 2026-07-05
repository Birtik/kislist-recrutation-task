<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260703211603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add book table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
                CREATE TABLE book (
                    serial_id INTEGER NOT NULL PRIMARY KEY,
                    title VARCHAR(255) NOT NULL,
                    author VARCHAR(255) NOT NULL,
                    CONSTRAINT serial_definition_book CHECK (serial_id BETWEEN 100000 AND 999999),
                    CONSTRAINT unique_serial_book UNIQUE (serial_id)
                );
            SQL,
        );
    }

    public function down(Schema $schema): void
    {
    }
}
