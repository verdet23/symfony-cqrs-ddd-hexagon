<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\ValueObject;

use App\Shared\Domain\ValueObject\AbstractInt;
use Assert\Assertion;

class IntImpl extends AbstractInt
{
    protected function validate(): void
    {
        Assertion::min($this->value, 4);
    }
}
