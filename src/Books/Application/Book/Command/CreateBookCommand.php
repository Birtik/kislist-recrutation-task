<?php

declare(strict_types=1);

namespace Task\Books\Application\Book\Command;

use Task\Books\Domain\Book\SerialNumber;

class CreateBookCommand
{
    public function __construct(
        public SerialNumber $serialId,
        public string $title,
        public string $author,
    ) {
    }
}