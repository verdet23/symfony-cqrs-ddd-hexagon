<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\ValueObject;

use Assert\Assertion;
use PHPUnit\Framework\TestCase;

class AbstractUuidTest extends TestCase
{
    public function testUuid(): void
    {
        $item = UuidImpl::generate();

        $this->assertTrue(Assertion::uuid($item->toString()));
    }
}
