<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\Exception;

use App\Shared\Domain\Exception\InvalidExceptionForFormatterPassedException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class InvalidExceptionForFormatterPassedExceptionTest extends TestCase
{
    public function testCreate(): void
    {
        $exception = InvalidExceptionForFormatterPassedException::create(InvalidExceptionForFormatterPassedException::class, new RuntimeException());

        $this->assertSame('Unsuitable exception passed for formatter, expected "App\Shared\Domain\Exception\InvalidExceptionForFormatterPassedException", actual "RuntimeException"', $exception->getMessage());
    }
}
