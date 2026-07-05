<?php

declare(strict_types=1);

namespace Tests\Books\Functional;

use Symfony\Component\HttpFoundation\Request;
use Tests\Books\Utils\TestDB;

final class UpdateBookHireStatusTest extends BooksBaseTestCase
{
    public function testBorrowBook(): void
    {
        TestDB::insert('book', ['serial_id' => 123456, 'title' => 'Book 1', 'author' => 'Author 1']);
        TestDB::insert('borrower', ['serial_id' => 654321]);
        $this->makeRequest('borrowed');

        TestDB::assertRecordExists('borrower', ['serial_id' => 654321], ['serial_id']);
        TestDB::assertRecordExists(
            'hire',
            [
                'borrower_serial_id' => 654321,
                'book_serial_id' => 123456,
                'returned_at' => null,
            ],

        );

        self::assertResponseIsSuccessful();
    }

    public function testReturnBook(): void
    {
        TestDB::insert('book', ['serial_id' => 123456, 'title' => 'Book 1', 'author' => 'Author 1']);
        TestDB::insert('borrower', ['serial_id' => 654321]);
        TestDB::insert(
            'hire',
            [
                'book_serial_id' => 123456,
                'borrower_serial_id' => 654321,
                'borrowed_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
            ],
        );

        $this->makeRequest('returned');

        self::assertResponseIsSuccessful();
        TestDB::assertRecordExists('borrower', ['serial_id' => 654321], ['serial_id']);
        TestDB::assertRecordExists('hire', ['borrower_serial_id' => 654321, 'book_serial_id' => 123456]);
    }

    private function makeRequest(string $status): void
    {
        $this->jsonRequest(
            Request::METHOD_PUT,
            '/api/books',
            [
                'book_serial_id' => 123456,
                'borrower_serial_id' => 654321,
                'hire_status' => $status,
            ],
        );
    }
}