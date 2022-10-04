<?php

declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use App\Shared\Domain\ValueObject\AbstractString;
use Assert\Assert;

class DisplayName extends AbstractString
{
    protected function validate(): void
    {
        Assert::lazy()->tryAll()
            ->that($this->value)->minLength(4, null, 'displayName')
            ->that($this->value)->maxLength(128, null, 'displayName')
            ->verifyNow();
    }
}
