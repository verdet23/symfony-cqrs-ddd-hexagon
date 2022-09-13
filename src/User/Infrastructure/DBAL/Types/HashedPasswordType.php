<?php

declare(strict_types=1);

namespace App\User\Infrastructure\DBAL\Types;

use App\Shared\Infrastructure\DBAL\Types\AbstractString;
use App\User\Domain\ValueObject\HashedPassword;

class HashedPasswordType extends AbstractString
{
    protected function getValueObjectClassName(): string
    {
        return HashedPassword::class;
    }
}
