<?php

declare(strict_types=1);

namespace Task\Books\Framework\Validation;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;
use Task\Books\Application\Book\Validator\ValidatorDefinition;

final class DeleteBookDefinition implements ValidatorDefinition
{
    public function getDefinition(): Collection
    {
        return new Collection([
            'allowMissingFields' => false,
            'allowExtraFields' => false,
            'fields' => [
                'serial_id' => [
                    new NotBlank(),
                    new Type('integer'),
                    new Range(min: 100000, max: 999999),
                ],
            ],
        ]);
    }
}