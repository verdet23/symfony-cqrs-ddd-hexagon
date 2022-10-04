<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\ValueObject;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AbstractIntTest extends TestCase
{
    public function testImpl(): void
    {
        $item = IntImpl::fromInt(5);

        $this->assertSame(5, $item->toInt());
        $this->assertSame(5, $item->jsonSerialize());
    }

    public function testValidation(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Number "2" was expected to be at least "4".');

        IntImpl::fromInt(2);
    }
}
