<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260704055934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add hire table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
                CREATE TABLE hire (
                    book_serial_id INTEGER NOT NULL,
                    borrower_serial_id INTEGER NOT NULL,
                    borrowed_at TIMESTAMP NOT NULL,
                    returned_at TIMESTAMP DEFAULT NULL,
                    CONSTRAINT fk_book_id FOREIGN KEY (book_serial_id) REFERENCES book (serial_id),
                    CONSTRAINT fk_borrower_id FOREIGN KEY (borrower_serial_id) REFERENCES borrower (serial_id),
                    CONSTRAINT unique_borrower_book UNIQUE (borrower_serial_id, book_serial_id, borrowed_at)
                );
            SQL,
        );
    }

    public function down(Schema $schema): void
    {
    }
}
