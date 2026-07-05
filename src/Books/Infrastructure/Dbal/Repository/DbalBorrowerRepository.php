<?php

declare(strict_types=1);

namespace Task\Books\Infrastructure\Dbal\Repository;

use Doctrine\DBAL\Connection;
use Task\Books\Domain\Borrower\Repository\BorrowerRepository;
use Task\Books\Domain\Borrower\SerialNumber as BorrowerSerialNumber;

final readonly class DbalBorrowerRepository implements BorrowerRepository
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function store(BorrowerSerialNumber $borrowerSerialNumber): void
    {
        $this->connection->executeStatement(
            'INSERT INTO borrower (serial_id) VALUES (:serial_id) ON CONFLICT (serial_id) DO NOTHING',
            [
                'serial_id' => $borrowerSerialNumber->value(),
            ],
        );
    }
}