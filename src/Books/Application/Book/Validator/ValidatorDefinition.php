<?php

declare(strict_types=1);

namespace Task\Books\Application\Book\Validator;

use Symfony\Component\Validator\Constraints\Collection;

interface ValidatorDefinition
{
    public function getDefinition(): Collection;
}