<?php

declare(strict_types=1);

namespace App\Blog\Post\Domain\ValueObject;

use App\Shared\Domain\ValueObject\AbstractString;
use Assert\Assertion;

final class Title extends AbstractString
{
    protected function validate(): void
    {
        Assertion::maxLength($this->value, 255);
    }
}
