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
        public ?int $borrowerSerialNumber = null,
        public ?\DateTimeImmutable $borrowedAt = null,
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
            (int) $data['borrower_serial_id'] ?? null,
            $data['borrowed_at'] ? new \DateTimeImmutable($data['borrowed_at']) : null,
        );
    }

    public function toArray(): array
    {
        $baseData = [
            'serial_id' => $this->serialId,
            'title' => $this->title,
            'author' => $this->author,
            'is_available' => $this->isAvailable,
        ];

        if (false === $this->isAvailable) {
            $extraData = [
                'borrower_serial_id' => $this->borrowerSerialNumber,
                'borrowed_at' => $this->borrowedAt?->format('Y-m-d H:i:s'),
            ];
        }

        return array_merge($baseData, $extraData ?? []);
    }
}