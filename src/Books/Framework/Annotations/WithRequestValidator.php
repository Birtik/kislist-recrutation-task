<?php

declare(strict_types=1);

namespace Task\Books\Framework\Annotations;

use Attribute;
use Task\Books\Application\Book\Validator\ValidatorDefinition;

#[\Attribute(Attribute::TARGET_METHOD)]
final readonly class WithRequestValidator
{
    public function __construct(
        public ValidatorDefinition $validatorDefinition,
    ) {
    }
}