<?php

declare(strict_types=1);

namespace Task\Books\Application\Book\View;

final readonly class BookView
{
    public function __construct(
        public int $serialId,
        public string $title,
        public string $author,
        public bool $isAvailable,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $isAvailable = $data['is_available'] ?? true;

        return new self(
            (int) $data['serial_id'],
            $data['title'],
            $data['author'],
            (bool) $isAvailable,
        );
    }

    public function toArray(): array
    {
        return [
            'serial_id' => $this->serialId,
            'title' => $this->title,
            'author' => $this->author,
            'is_available' => $this->isAvailable,
        ];
    }
}