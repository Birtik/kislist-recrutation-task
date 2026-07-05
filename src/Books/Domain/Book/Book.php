<?php

declare(strict_types=1);

namespace Task\Books\Domain\Book;

class Book
{
    public function __construct(
        public SerialNumber $serialId,
        public string $title,
        public string $author,
    ) {
    }

    public function toArray(): array
    {
        return [
            'serial_id' => $this->serialId->value(),
            'title' => $this->title,
            'author' => $this->author,
        ];
    }
}