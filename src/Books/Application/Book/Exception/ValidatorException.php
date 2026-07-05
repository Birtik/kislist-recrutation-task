<?php

namespace Task\Books\Application\Book\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class ValidatorException extends \Exception
{

    private array $violations = [];

    public function __construct(
        private readonly ConstraintViolationListInterface $violationsList,
        Throwable $previous = null,
    ) {
        $this->parseViolationsAsArray($this->violationsList);

        parent::__construct(
            'Validator errors',
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $previous,
        );
    }

    public function getViolations(): array
    {
        return $this->violations;
    }

    public function getViolationsList(): ConstraintViolationListInterface
    {
        return $this->violationsList;
    }

    private function parseViolationsAsArray(ConstraintViolationListInterface $violationList): void
    {
        /** @var ConstraintViolationInterface $error */
        foreach ($violationList as $error) {
            $this->violations[] = [
                'code' => $error->getCode(),
                'field' => $error->getPropertyPath(),
                'message' => $error->getMessage(),
            ];
        }
    }
}