<?php

declare(strict_types=1);

namespace App\User\Infrastructure\DBAL\Types;

use App\Shared\Infrastructure\DBAL\Types\AbstractEmail;
use App\User\Domain\ValueObject\Email;

class EmailType extends AbstractEmail
{
    protected function getValueObjectClassName(): string
    {
        return Email::class;
    }
}
