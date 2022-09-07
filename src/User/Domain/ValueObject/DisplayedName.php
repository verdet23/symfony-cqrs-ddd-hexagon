<?php

declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use App\Shared\Domain\ValueObject\AbstractString;
use Assert\Assertion;

class DisplayedName extends AbstractString
{
    protected function validate(): void
    {
        Assertion::maxLength($this->value, 128);
    }
}
