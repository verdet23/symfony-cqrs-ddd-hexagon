<?php

declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use App\Shared\Domain\ValueObject\AbstractString;
use Assert\Assert;

class Username extends AbstractString
{
    public const REGEX = '/^[A-Za-z0-9-_]+$/';

    protected function validate(): void
    {
        Assert::lazy()->tryAll()
            ->that($this->value)->minLength(4, null, 'username')
            ->that($this->value)->maxLength(64, null, 'username')
            ->that($this->value)->regex(self::REGEX, null, 'username')
            ->verifyNow();
    }
}
