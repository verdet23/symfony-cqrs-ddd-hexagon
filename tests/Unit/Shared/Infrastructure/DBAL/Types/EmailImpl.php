<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\DBAL\Types;

use App\Shared\Infrastructure\DBAL\Types\AbstractEmail;

class EmailImpl extends AbstractEmail
{
    protected function getValueObjectClassName(): string
    {
        return 'VO';
    }
}
