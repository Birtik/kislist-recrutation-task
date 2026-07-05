<?php

declare(strict_types=1);

namespace Task\Books\Application\Book\View;

class BookViewCollection
{
    private array $bookView;

    public function __construct(BookView ...$bookView)
    {
        $this->bookView = $bookView;
    }

    public function jsonSerialize(): array
    {
        return array_map(function (BookView $bookView) {
            return $bookView->toArray();
        }, $this->bookView);
    }
}