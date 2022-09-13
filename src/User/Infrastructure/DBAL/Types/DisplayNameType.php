<?php

declare(strict_types=1);

namespace App\User\Infrastructure\DBAL\Types;

use App\Shared\Infrastructure\DBAL\Types\AbstractString;
use App\User\Domain\ValueObject\DisplayName;

class DisplayNameType extends AbstractString
{
    protected function getValueObjectClassName(): string
    {
        return DisplayName::class;
    }
}
