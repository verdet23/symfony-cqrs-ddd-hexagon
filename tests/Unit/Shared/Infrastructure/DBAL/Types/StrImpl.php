<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\DBAL\Types;

use App\Shared\Infrastructure\DBAL\Types\AbstractString;

class StrImpl extends AbstractString
{
    protected function getValueObjectClassName(): string
    {
        return \App\Tests\Unit\Shared\Domain\ValueObject\StrImpl::class;
    }
}
