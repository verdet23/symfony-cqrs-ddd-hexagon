<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\ValueObject;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AbstractStringTest extends TestCase
{
    public function testImpl(): void
    {
        $item = StrImpl::fromString('rand str');

        $this->assertSame('rand str', $item->toString());
        $this->assertSame('rand str', $item->jsonSerialize());
    }

    public function testValidation(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value "tr" is too short, it should have at least 3 characters, but only has 2 characters.');

        StrImpl::fromString('tr');
    }
}
