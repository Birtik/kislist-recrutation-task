<?php

declare(strict_types=1);

namespace Task\Books\Infrastructure\Dbal\Repository;

use Doctrine\DBAL\Connection;
use Task\Books\Domain\Book\Book;
use Task\Books\Domain\Book\Repository\BookRepository;
use Task\Books\Domain\Book\SerialNumber;

final readonly class DbalBookRepository implements BookRepository
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function store(Book $book): void
    {
        $this->connection->insert(
            'book',
            $book->toArray(),
        );
    }

    public function remove(SerialNumber $serialNumber): void
    {
        $this->connection->delete(
            'book',
            ['serial_id' => $serialNumber->value()],
        );
    }
}