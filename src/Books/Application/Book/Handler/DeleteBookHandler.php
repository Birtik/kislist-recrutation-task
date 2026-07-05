<?php

declare(strict_types=1);

namespace Task\Books\Application\Book\Handler;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Task\Books\Application\Book\Command\DeleteBookCommand;
use Task\Books\Domain\Book\Repository\BookRepository;

#[AsMessageHandler]
final readonly class DeleteBookHandler
{
    public function __construct(
        private BookRepository $bookRepository,
    ) {
    }

    public function __invoke(DeleteBookCommand $command): void
    {
        $this->bookRepository->remove($command->serialId);
    }
}