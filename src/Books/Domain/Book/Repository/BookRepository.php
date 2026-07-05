<?php

declare(strict_types=1);

namespace Task\Books\Domain\Book\Repository;

use Task\Books\Domain\Book\Book;
use Task\Books\Domain\Book\SerialNumber;

interface BookRepository
{
    public function store(Book $book): void;
    public function remove(SerialNumber $serialNumber): void;
}