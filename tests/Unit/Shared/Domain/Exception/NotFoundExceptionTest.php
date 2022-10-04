<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\Exception;

use App\Shared\Domain\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;

class NotFoundExceptionTest extends TestCase
{
    public function testCreate(): void
    {
        $exception = NotFoundException::create();

        $this->assertSame('Resource not found', $exception->getMessage());
    }
}
