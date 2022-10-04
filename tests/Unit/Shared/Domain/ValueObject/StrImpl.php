<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\ValueObject;

use App\Shared\Domain\ValueObject\AbstractString;
use Assert\Assertion;

class StrImpl extends AbstractString
{
    protected function validate(): void
    {
        Assertion::minLength($this->value, 3);
    }
}
