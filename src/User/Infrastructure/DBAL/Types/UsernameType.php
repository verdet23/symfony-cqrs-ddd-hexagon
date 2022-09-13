<?php

declare(strict_types=1);

namespace App\User\Infrastructure\DBAL\Types;

use App\Shared\Infrastructure\DBAL\Types\AbstractString;
use App\User\Domain\ValueObject\Username;

class UsernameType extends AbstractString
{
    protected function getValueObjectClassName(): string
    {
        return Username::class;
    }
}
