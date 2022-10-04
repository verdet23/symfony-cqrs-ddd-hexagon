<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DBAL\Types;

use App\Shared\Domain\ValueObject\AbstractString as VOString;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;

abstract class AbstractString extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof VOString) {
            return $value->toString();
        }

        if (null === $value || '' === $value) {
            return null;
        }

        if (!\is_string($value)) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', 'string', VOString::class]);
        }

        try {
            return $this->getValueObjectClassName()::fromString($value)->toString();
        } catch (\InvalidArgumentException $exception) {
            throw ConversionException::conversionFailed($value, $this->getName(), $exception);
        }
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?VOString
    {
        if ($value instanceof VOString || null === $value) {
            return $value;
        }

        if (!\is_string($value)) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', 'string', VOString::class]);
        }

        try {
            return $this->getValueObjectClassName()::fromString($value);
        } catch (\Exception $exception) {
            throw ConversionException::conversionFailed($value, $this->getName(), $exception);
        }
    }

    public function getName(): string
    {
        return static::class;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    abstract protected function getValueObjectClassName(): string;
}
