<?php

declare(strict_types=1);

namespace Task\Books\Application\Book\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Task\Books\Application\Book\Exception\ValidatorException;

class RequestDataValidator
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * @throws ValidatorException
     */
    public function validate(array $data, ValidatorDefinition $definition): void
    {
        $errors = $this->validator->validate($data, $definition->getDefinition());

        if (0 !== $errors->count()) {
            throw new ValidatorException($errors);
        }
    }
}