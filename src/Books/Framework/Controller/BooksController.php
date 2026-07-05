<?php

declare(strict_types=1);

namespace Task\Books\Framework\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Task\Books\Application\Book\Command\CreateBookCommand;
use Task\Books\Application\Book\Command\DeleteBookCommand;
use Task\Books\Application\Book\Command\UpdateBookCommand;
use Task\Books\Application\Book\View\BuildBookViewCollection;
use Task\Books\Domain\Book\SerialNumber as BookSerialNumber;
use Task\Books\Domain\Borrower\SerialNumber as BorrowerSerialNumber;
use Task\Books\Framework\Annotations\WithRequestValidator;
use Task\Books\Framework\Validation\CreateBookDefinition;
use Task\Books\Framework\Validation\DeleteBookDefinition;
use Task\Books\Framework\Validation\UpdateBookHireStatusDefinition;

class BooksController extends AbstractController
{
    public function __construct(
        private readonly BuildBookViewCollection $buildBookViewCollection,
        private readonly MessageBusInterface $messageBus,
    ) {
    }

    #[Route('/api/books', name: 'GET_BOOKS', methods: ['GET'])]
    public function getBooksCollection(): JsonResponse
    {
        $bookViewCollection = ($this->buildBookViewCollection)();

        return new JsonResponse($bookViewCollection->jsonSerialize());
    }

    #[Route('/api/books', name: 'UPDATE_BOOK', methods: ['PUT'])]
    #[WithRequestValidator(new UpdateBookHireStatusDefinition())]
    public function updateBook(Request $request): JsonResponse
    {
        $bookData = $request->toArray();

        $this->messageBus->dispatch(
            new UpdateBookCommand(
                new BookSerialNumber($bookData['book_serial_id']),
                new BorrowerSerialNumber($bookData['borrower_serial_id']),
                $bookData['hire_status'],
            ),
        );

        return new JsonResponse();
    }

    #[Route('/api/books', name: 'DELETE_BOOK', methods: ['DELETE'])]
    #[WithRequestValidator(new DeleteBookDefinition())]
    public function deleteBook(Request $request): JsonResponse
    {
        $bookData = $request->toArray();

        $this->messageBus->dispatch(
            new DeleteBookCommand(
                new BookSerialNumber($bookData['serial_id']),
            ),
        );

        return new JsonResponse();
    }

    #[Route('/api/books', name: 'CREATE_BOOK', methods: ['POST'])]
    #[WithRequestValidator(new CreateBookDefinition())]
    public function createBook(Request $request): JsonResponse
    {
        $bookData = $request->toArray();

        $this->messageBus->dispatch(
            new CreateBookCommand(
                new BookSerialNumber($bookData['serial_id']),
                $bookData['title'],
                $bookData['author'],
            ),
        );

        return new JsonResponse();
    }
}