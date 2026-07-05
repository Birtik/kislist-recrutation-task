<?php

declare(strict_types=1);

namespace Task\Books\Infrastructure\Dbal\Repository;

use Doctrine\DBAL\Connection;
use Task\Books\Domain\Book\SerialNumber as BookSerialNumber;
use Task\Books\Domain\Borrower\SerialNumber as BorrowerSerialNumber;
use Task\Books\Domain\Hire\Repository\HireRepository;

final readonly class DbalHireRepository implements HireRepository
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function store(BookSerialNumber $bookSerialNumber, BorrowerSerialNumber $borrowerSerialNumber): void
    {
        $this->connection->insert(
            'hire',
            [
                'borrower_serial_id' => $borrowerSerialNumber->value(),
                'book_serial_id' => $bookSerialNumber->value(),
                'borrowed_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
            ],
        );
    }

    public function markAsReturned(
        BookSerialNumber $bookSerialNumber,
        BorrowerSerialNumber $borrowerSerialNumber,
    ): void {
        $this->connection->update(
            'hire',
            [
                'returned_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
            ],
            [
                'borrower_serial_id' => $borrowerSerialNumber->value(),
                'book_serial_id' => $bookSerialNumber->value(),
            ],
        );
    }

    public function isHiredBook(BookSerialNumber $bookSerialNumber, BorrowerSerialNumber $borrowerSerialNumber): bool
    {
        $sql = <<<SQL
            SELECT 1 
            FROM hire 
            WHERE book_serial_id = :bookSerialNumber 
              AND borrower_serial_id = :borrowerSerialNumber
              AND returned_at IS NULL
        SQL;

        return (bool) $this->connection->fetchOne(
            $sql,
            [
                'bookSerialNumber' => $bookSerialNumber->value(),
                'borrowerSerialNumber' => $borrowerSerialNumber->value(),
            ],
        );
    }
}