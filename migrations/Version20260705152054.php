<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260705152054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add cascade delete to hire foreign keys';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE hire DROP CONSTRAINT fk_book_id');
        $this->addSql('ALTER TABLE hire DROP CONSTRAINT fk_borrower_id');
        $this->addSql('ALTER TABLE hire ADD CONSTRAINT fk_book_id FOREIGN KEY (book_serial_id) REFERENCES book (serial_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hire ADD CONSTRAINT fk_borrower_id FOREIGN KEY (borrower_serial_id) REFERENCES borrower (serial_id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
    }
}
