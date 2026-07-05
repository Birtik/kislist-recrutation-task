<?php

declare(strict_types=1);

namespace Task\Books\Domain\Borrower\Repository;

use Task\Books\Domain\Book\SerialNumber as BookSerialNumber;
use Task\Books\Domain\Borrower\SerialNumber as BorrowerSerialNumber;

interface BorrowerRepository
{
    public function store(BorrowerSerialNumber $borrowerSerialNumber): void;
}