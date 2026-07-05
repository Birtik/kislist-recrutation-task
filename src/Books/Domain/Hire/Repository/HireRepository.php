<?php

declare(strict_types=1);

namespace Task\Books\Domain\Hire\Repository;

use Task\Books\Domain\Book\SerialNumber as BookSerialNumber;
use Task\Books\Domain\Borrower\SerialNumber as BorrowerSerialNumber;

interface HireRepository
{
    public function store(BookSerialNumber $bookSerialNumber, BorrowerSerialNumber $borrowerSerialNumber): void;
    public function markAsReturned(
        BookSerialNumber $bookSerialNumber,
        BorrowerSerialNumber $borrowerSerialNumber,
    ): void;

    public function isHiredBook(BookSerialNumber $bookSerialNumber, BorrowerSerialNumber $borrowerSerialNumber): bool;
}