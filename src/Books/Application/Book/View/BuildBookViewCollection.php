<?php

declare(strict_types=1);

namespace Task\Books\Application\Book\View;

use Task\Books\Application\Book\Query\GetBookListDataQuery;

final readonly class BuildBookViewCollection
{
    public function __construct(
        private GetBookListDataQuery $bookListDataQuery,
    ) {
    }

    public function __invoke(): BookViewCollection
    {
        $bookViewCollection = [];
        $rawBooks = $this->bookListDataQuery->getListOfBooks();

        foreach ($rawBooks as $rawBook) {
            $bookViewCollection[] = BookView::fromArray($rawBook);
        }

        return new BookViewCollection(...$bookViewCollection);
    }
}