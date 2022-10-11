<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Assert\Assert;

abstract class AbstractEmail extends AbstractString
{
    protected function validate(): void
    {
        Assert::lazy()->tryAll()
            ->that($this->value, 'email')->email()->maxLength(320)
            ->verifyNow();
    }
}
