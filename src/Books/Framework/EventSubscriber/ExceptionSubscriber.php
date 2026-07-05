<?php

namespace Task\Books\Framework\EventSubscriber;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Task\Books\Application\Book\Exception\BookIsAlreadyExists;
use Task\Books\Framework\Response\Json\ErrorWithCodeResponse;
use Throwable;

final readonly class ExceptionSubscriber
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        $request = $event->getRequest();

        if ($this->isFromCurrentContext($request) && $this->hasAcceptableContentType($request)) {
            $response = $this->createApiResponse($throwable);
            $event->setResponse($response);
        }
    }

    private function isFromCurrentContext(Request $request): bool
    {
        return str_contains($request->getPathInfo(), '/api/books');
    }

    private function hasAcceptableContentType(Request $request): bool
    {
        return in_array('application/json', $request->getAcceptableContentTypes(), true)
            || in_array('*/*', $request->getAcceptableContentTypes(), true);
    }

    private function createApiResponse(Throwable $throwable): Response
    {
        if ($throwable instanceof BookIsAlreadyExists) {
            return new ErrorWithCodeResponse(
                'Book with this serial id already exists',
                'B0002',
                Response::HTTP_CONFLICT,
            );
        }

        return new ErrorWithCodeResponse(
            $throwable->getMessage(),
            'B0001',
            Response::HTTP_INTERNAL_SERVER_ERROR,
        );
    }
}