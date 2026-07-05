<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260704055428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add borrower table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
                CREATE TABLE borrower (
                    serial_id INTEGER NOT NULL,
                    CONSTRAINT serial_definition_borrower CHECK (serial_id BETWEEN 100000 AND 999999),
                    CONSTRAINT unique_serial_borrower UNIQUE (serial_id)
                );
            SQL,
        );
    }

    public function down(Schema $schema): void
    {
    }
}
