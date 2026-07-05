<?php

declare(strict_types=1);

namespace Task\Books\Application\Book\Command;

use Task\Books\Domain\Book\SerialNumber as BookSerialNumber;
use Task\Books\Domain\Borrower\SerialNumber as BorrowerSerialNumber;

final class UpdateBookCommand
{
    public function __construct(
        public BookSerialNumber $bookSerialNumber,
        public BorrowerSerialNumber $borrowerSerialNumber,
        public string $status,
    ) {
    }
}