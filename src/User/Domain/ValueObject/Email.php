<?php

declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use App\Shared\Domain\ValueObject\AbstractString;
use Assert\Assert;

final class Email extends AbstractString
{
    protected function validate(): void
    {
        Assert::lazy()->tryAll()
            ->that($this->value)->email()
            ->that($this->value)->maxLength(64)
            ->verifyNow();
    }
}
