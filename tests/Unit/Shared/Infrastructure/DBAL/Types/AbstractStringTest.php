<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\DBAL\Types;

use App\Tests\Unit\Shared\Domain\ValueObject\StrImpl as VOString;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;

class AbstractStringTest extends TestCase
{
    private AbstractPlatform&MockObject $platform;

    protected function setUp(): void
    {
        $this->platform = $this->getMockForAbstractClass(AbstractPlatform::class);
        parent::setUp();
    }

    public function testConvertToDatabaseValue(): void
    {
        $type = new StrImpl();
        $item = VOString::fromString('Rise n shine');

        $result = $type->convertToDatabaseValue($item, $this->platform);

        $this->assertSame('Rise n shine', $result);
    }

    public function testConvertToDatabaseValueNull(): void
    {
        $type = new StrImpl();

        $result = $type->convertToDatabaseValue(null, $this->platform);

        $this->assertNull($result);
    }

    public function testConvertToDatabaseValueEmptyString(): void
    {
        $type = new StrImpl();

        $result = $type->convertToDatabaseValue('', $this->platform);

        $this->assertNull($result);
    }

    public function testConvertToDatabaseValueObject(): void
    {
        $this->expectException(ConversionException::class);
        $this->expectExceptionMessage('Could not convert PHP value of type stdClass to type App\Tests\Unit\Shared\Infrastructure\DBAL\Types\StrImpl. Expected one of the following types: null, string, App\Shared\Domain\ValueObject\AbstractString');
        $type = new StrImpl();

        $type->convertToDatabaseValue(new stdClass(), $this->platform);
    }

    public function testConvertToDatabaseValueFailed(): void
    {
        $this->expectException(ConversionException::class);
        $this->expectExceptionMessage('Could not convert database value "Re" to Doctrine Type App\Tests\Unit\Shared\Infrastructure\DBAL\Types\StrImpl');

        $type = new StrImpl();

        $type->convertToDatabaseValue('Re', $this->platform);
    }

    public function testConvertToPHPValue(): void
    {
        $type = new StrImpl();

        $result = $type->convertToPHPValue('Re-invite', $this->platform);

        $this->assertInstanceOf(VOString::class, $result);

        $this->assertSame('Re-invite', $result->toString());
    }

    public function testConvertToPHPValueNull(): void
    {
        $type = new StrImpl();

        $result = $type->convertToPHPValue(null, $this->platform);

        $this->assertNull($result);
    }

    public function testConvertToPHPValueAlreadyVO(): void
    {
        $type = new StrImpl();
        $item = VOString::fromString('Rise n shine');

        $result = $type->convertToPHPValue($item, $this->platform);

        $this->assertSame($item, $result);
    }

    public function testConvertToPHPValueObject(): void
    {
        $this->expectException(ConversionException::class);
        $this->expectExceptionMessage('Could not convert PHP value of type stdClass to type App\Tests\Unit\Shared\Infrastructure\DBAL\Types\StrImpl. Expected one of the following types: null, string, App\Shared\Domain\ValueObject\AbstractString');

        $type = new StrImpl();
        $type->convertToPHPValue(new stdClass(), $this->platform);
    }

    public function testConvertToPHPValueFailed(): void
    {
        $this->expectException(ConversionException::class);
        $this->expectExceptionMessage('Could not convert database value "RS" to Doctrine Type App\Tests\Unit\Shared\Infrastructure\DBAL\Types\StrImpl');

        $type = new StrImpl();
        $type->convertToPHPValue('RS', $this->platform);
    }

    public function testGetName(): void
    {
        $type = new StrImpl();

        $this->assertSame($type::class, $type->getName());
    }

    public function testRequiresSQLCommentHint(): void
    {
        $type = new StrImpl();

        $this->assertTrue($type->requiresSQLCommentHint($this->platform));
    }
}
