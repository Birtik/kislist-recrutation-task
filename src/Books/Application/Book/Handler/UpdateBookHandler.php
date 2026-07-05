<?php

declare(strict_types=1);

namespace Task\Books\Application\Book\Handler;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Task\Books\Application\Book\Command\UpdateBookCommand;
use Task\Books\Domain\Borrower\Repository\BorrowerRepository;
use Task\Books\Domain\Hire\Repository\HireRepository;
use Task\Books\Domain\Hire\HireStatus;

#[AsMessageHandler]
final readonly class UpdateBookHandler
{
    public function __construct(
        private HireRepository $hireRepository,
        private BorrowerRepository $borrowerRepository,
    ) {
    }

    public function __invoke(UpdateBookCommand $command): void
    {
        $hireStatus = HireStatus::from($command->status);
        $isHired = $this->hireRepository->isHiredBook($command->bookSerialNumber, $command->borrowerSerialNumber);

        if (HireStatus::BORROWED === $hireStatus && !$isHired) {
            $this->borrowerRepository->store($command->borrowerSerialNumber);
            $this->hireRepository->store($command->bookSerialNumber, $command->borrowerSerialNumber);

            return;
        }

        if (HireStatus::RETURNED === $hireStatus && $isHired) {
            $this->hireRepository->markAsReturned($command->bookSerialNumber, $command->borrowerSerialNumber);

            return;
        }
    }
}