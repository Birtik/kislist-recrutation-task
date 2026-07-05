<?php

declare(strict_types=1);

namespace Task\Books\Framework\Response\Json;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ErrorWithCodeResponse extends JsonResponse
{
    public function __construct(string $errorMessage, string|int $code, int $status)
    {
        parent::__construct([
            'error' => [
                'message' => $errorMessage,
                'code' => $code,
            ],
        ], $status);
    }

    public static function internalError(string|int $code, string $message = 'Internal server error'): self
    {
        return new self($message, $code, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public static function notFound(string|int $code, string $message = 'Not found'): self
    {
        return new self($message, $code, Response::HTTP_NOT_FOUND);
    }

    public static function badRequest(string|int $code, string $message = 'Bad request'): self
    {
        return new self($message, $code, Response::HTTP_BAD_REQUEST);
    }

    public static function unprocessable(string|int $code, string $message = 'Could not process request'): self
    {
        return new self($message, $code, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}