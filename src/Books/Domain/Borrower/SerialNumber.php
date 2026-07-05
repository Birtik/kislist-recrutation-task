<?php

declare(strict_types=1);

namespace Task\Books\Domain\Borrower;

use InvalidArgumentException;

final readonly class SerialNumber
{
    public function __construct(private int $value)
    {
        if ($value < 100000 || $value > 999999) {
            throw new InvalidArgumentException('Serial number must be between 100000 and 999999');
        }
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}