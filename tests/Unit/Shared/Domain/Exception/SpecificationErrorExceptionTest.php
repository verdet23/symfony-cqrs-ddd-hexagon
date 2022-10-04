<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\Exception;

use App\Shared\Domain\Exception\SpecificationErrorException;
use PHPUnit\Framework\TestCase;

class SpecificationErrorExceptionTest extends TestCase
{
    public function testCreate(): void
    {
        $exception = SpecificationErrorException::create('Out of range', 'text');

        $this->assertSame('Specification error "Out of range" at [text]', $exception->getMessage());
        $this->assertSame('text', $exception->propertyPath());
        $this->assertSame('Out of range', $exception->baseMessage());
    }
}
