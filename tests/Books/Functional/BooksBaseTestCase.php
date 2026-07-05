<?php

declare(strict_types=1);

namespace Tests\Books\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Tests\Books\Utils\KernelBrowserHttpClientTrait;
use Tests\Books\Utils\TestDB;

abstract class BooksBaseTestCase extends WebTestCase
{
    use KernelBrowserHttpClientTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpHttpClient();

        $connection = static::getContainer()->get('doctrine.dbal.default_connection');

        TestDB::$connection = $connection;

        if (!$connection->isTransactionActive()) {
            $connection->beginTransaction();
        }
    }

    protected function tearDown(): void
    {
        $connection = TestDB::$connection ?? null;

        if ($connection !== null && $connection->isTransactionActive()) {
            $connection->rollBack();
        }

        parent::tearDown();
    }

    public static function getJsonResponse(AbstractBrowser $client): array
    {
        return json_decode((string) $client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }
}
