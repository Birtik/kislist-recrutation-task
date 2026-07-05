<?php

declare(strict_types=1);

namespace Tests\Books\Utils;

use Doctrine\DBAL\Connection;
use PHPUnit\Framework\Assert;

final class TestDB
{
    public static Connection $connection;


    public static function assertRecordExists(
        string $tableName,
        array $conditions,
        array $columnNames = ['*'],
        string $message = 'Record not found',
    ): array {
        $result = self::getRecord($tableName, $conditions, $columnNames);

        Assert::assertNotEmpty($result, $message);

        return $result;
    }

    public static function assertRecordMissing(
        string $tableName,
        array $conditions = [],
        string $message = 'Record was found, but should be missing',
    ): void {
        $result = self::getRecord($tableName, $conditions);

        Assert::assertEmpty($result, $message);
    }

    public static function getRecord(string $tableName, array $conditions, array $columnNames = ['*']): array|string|int
    {
        $queryBuilder = self::$connection
            ->createQueryBuilder()
            ->select(implode(',', $columnNames))
            ->from($tableName);

        foreach ($conditions as $column => $value) {
            if (null === $value) {
                $queryBuilder
                    ->andWhere("$column IS NULL");
            } else {
                $queryBuilder
                    ->andWhere("$column = :$column")
                    ->setParameter($column, $value);
            }
        }

        $result = $queryBuilder->execute()->fetchAssociative();

        if (false === $result) {
            return [];
        }

        return $result;
    }

    public static function update(string $tableName, array $data, array $criteria, array $types = []): void
    {
        self::$connection->update($tableName, $data, $criteria, $types);
    }

    public static function insert(string $tableName, array $data): void
    {
        $connection = self::connection();

        $connection->insert($tableName, $data);
    }

    private static function connection(): Connection
    {
        return self::$connection;
    }
}
