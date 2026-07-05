<?php

namespace Tests\Books\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Task\Books\Domain\Book\SerialNumber;

class SerialNumberTest extends TestCase
{
    public function testCanBeCreatedWithValidValue(): void
    {
        $serialNumber = new SerialNumber(654321);

        self::assertSame(654321, $serialNumber->value());
    }

    public function testCanBeConvertedToString(): void
    {
        $serialNumber = new SerialNumber(654321);

        self::assertSame('654321', (string) $serialNumber);
    }

    public function testIsEqualToSerialNumberWithSameValue(): void
    {
        $serialNumber = new SerialNumber(654321);
        $otherSerialNumber = new SerialNumber(654321);

        self::assertTrue($serialNumber->equals($otherSerialNumber));
    }

    public function testIsNotEqualToSerialNumberWithDifferentValue(): void
    {
        $serialNumber = new SerialNumber(654321);
        $otherSerialNumber = new SerialNumber(123456);

        self::assertFalse($serialNumber->equals($otherSerialNumber));
    }

    public function testCannotBeCreatedWithValueLowerThanMinimum(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Serial number must be between 100000 and 999999');

        new SerialNumber(99999);
    }

    public function testCannotBeCreatedWithValueGreaterThanMaximum(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Serial number must be between 100000 and 999999');

        new SerialNumber(1000000);
    }

    public function testCanBeCreatedWithMinimumAllowedValue(): void
    {
        $serialNumber = new SerialNumber(100000);

        self::assertSame(100000, $serialNumber->value());
    }

    public function testCanBeCreatedWithMaximumAllowedValue(): void
    {
        $serialNumber = new SerialNumber(999999);

        self::assertSame(999999, $serialNumber->value());
    }
}