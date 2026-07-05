<?php

declare(strict_types=1);

namespace Tests\Books\Functional;

use Symfony\Component\HttpFoundation\Request;
use Tests\Books\Utils\TestDB;

final class GetAllBooksTest extends BooksBaseTestCase
{
    public function testGetAllBooks(): void
    {
        TestDB::insert('book', ['serial_id' => 123456, 'title' => 'Book 1', 'author' => 'Author 1']);

        $this->makeRequest();

        self::assertResponseIsSuccessful();
        self::assertEquals(
            [
                [
                    'serial_id' => 123456,
                    'title' => 'Book 1',
                    'author' => 'Author 1',
                    'is_available' => true,
                ]
            ],
            self::getJsonResponse($this->getHttpClient()),
        );
    }

    private function makeRequest(): void
    {
        $this->jsonRequest(
            Request::METHOD_GET,
            '/api/books'
        );
    }
}