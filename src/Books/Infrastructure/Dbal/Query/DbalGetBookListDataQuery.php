<?php

declare(strict_types=1);

namespace Task\Books\Infrastructure\Dbal\Query;

use Doctrine\DBAL\Connection;
use Task\Books\Application\Book\Query\GetBookListDataQuery;

final readonly class DbalGetBookListDataQuery implements GetBookListDataQuery
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function getListOfBooks(): array
    {
        $sql = <<<SQL
            SELECT
                book.serial_id,
                book.title,
                book.author,
                (SELECT 0 FROM hire WHERE book.serial_id = hire.book_serial_id AND hire.returned_at IS NULL) AS is_available,
                hire.borrower_serial_id,
                hire.borrowed_at
            FROM book
            LEFT JOIN hire ON book.serial_id = hire.book_serial_id
        SQL;

        return $this->connection->fetchAllAssociative($sql);
    }
}