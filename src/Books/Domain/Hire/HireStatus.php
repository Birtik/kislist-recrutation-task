<?php
declare(strict_types=1);

namespace Task\Books\Domain\Hire;

enum HireStatus: string
{
    case BORROWED = 'borrowed';
    case RETURNED = 'returned';
}
