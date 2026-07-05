<?php

declare(strict_types=1);

namespace Task\Books\Application\Book\Query;

interface GetBookListDataQuery
{
    public function getListOfBooks(): array;
}