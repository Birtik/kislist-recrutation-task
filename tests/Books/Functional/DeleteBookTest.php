<?php

declare(strict_types=1);

namespace Tests\Books\Functional;

use Symfony\Component\HttpFoundation\Request;
use Tests\Books\Utils\TestDB;

final class DeleteBookTest extends BooksBaseTestCase
{
    public function testDeleteBook(): void
    {
        TestDB::insert('book', ['serial_id' => 123456, 'title' => 'Book 1', 'author' => 'Author 1']);

        $this->makeRequest();

        self::assertResponseIsSuccessful();
    }

    private function makeRequest(): void
    {
        $this->jsonRequest(
            Request::METHOD_DELETE,
            '/api/books',
            [
                'serial_id' => 123456,
            ],
        );

        TestDB::assertRecordMissing('book', ['serial_id' => 123456]);
    }
}