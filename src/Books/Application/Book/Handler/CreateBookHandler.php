<?php

declare(strict_types=1);

namespace Task\Books\Application\Book\Handler;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Task\Books\Application\Book\Command\CreateBookCommand;
use Task\Books\Application\Book\Exception\BookIsAlreadyExists;
use Task\Books\Domain\Book\Book;
use Task\Books\Domain\Book\Repository\BookRepository;

#[AsMessageHandler]
final readonly class CreateBookHandler
{
    public function __construct(
        private BookRepository $bookRepository,
    ) {
    }

    /**
     * @throws BookIsAlreadyExists
     */
    public function __invoke(CreateBookCommand $command): void
    {
        $book = new Book(
            $command->serialId,
            $command->title,
            $command->author,
        );

        try {
            $this->bookRepository->store($book);
        } catch (UniqueConstraintViolationException $e) {
            throw new BookIsAlreadyExists();
        }
    }
}