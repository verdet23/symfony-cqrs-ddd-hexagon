<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\ExceptionFormatter;

use App\Shared\Domain\Exception\InvalidExceptionForFormatterPassedException;
use App\Shared\Domain\ExceptionFormatter\AssertionExceptionFormatter;
use Assert\InvalidArgumentException;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

class AssertionExceptionFormatterTest extends TestCase
{
    public function testIsSuitable(): void
    {
        $formatter = new AssertionExceptionFormatter();

        $this->assertTrue($formatter->isSuitable(new InvalidArgumentException('Error', 12)));
    }

    public function testIsNotSuitable(): void
    {
        $formatter = new AssertionExceptionFormatter();

        $this->assertFalse($formatter->isSuitable(LazyAssertionException::fromErrors([new InvalidArgumentException('Error', 12)])));
    }

    public function testFormat(): void
    {
        $formatter = new AssertionExceptionFormatter();

        $data = $formatter->format(new InvalidArgumentException('Error', 12, 'count', 65));

        $this->assertArrayHasKey('count', $data);

        $this->assertArrayHasKey('value', $data['count']);
        $this->assertArrayHasKey('message', $data['count']);

        $this->assertSame(65, $data['count']['value']);
        $this->assertSame('Error', $data['count']['message']);
    }

    public function testFormatWrongException(): void
    {
        $this->expectException(InvalidExceptionForFormatterPassedException::class);

        $formatter = new AssertionExceptionFormatter();
        $formatter->format(LazyAssertionException::fromErrors([new InvalidArgumentException('Error', 12)]));
    }
}
