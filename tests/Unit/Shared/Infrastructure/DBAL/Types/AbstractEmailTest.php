<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\DBAL\Types;

use App\Shared\Infrastructure\DBAL\Types\AbstractEmail;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\TestCase;

class AbstractEmailTest extends TestCase
{
    public function testGetSQLDeclaration(): void
    {
        $platform = $this->getMockBuilder(AbstractPlatform::class)
            ->onlyMethods(['getStringTypeDeclarationSQL'])
            ->getMockForAbstractClass();

        $platform->expects($this->once())
            ->method('getStringTypeDeclarationSQL')
            ->with(
                $this->callback(function (array $options): bool {
                    $this->assertArrayHasKey('length', $options);
                    $this->assertSame(320, $options['length']);

                    return true;
                })
            )
            ->willReturn('SQL D');

        $type = $this->getMockForAbstractClass(AbstractEmail::class);

        $type->getSQLDeclaration([], $platform);
    }
}
