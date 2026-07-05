<?php

declare(strict_types=1);

namespace Task\Books\Application\Book\Command;

use Task\Books\Domain\Book\SerialNumber;

final class DeleteBookCommand
{
    public function __construct(
        public SerialNumber $serialId,
    ) {
    }
}