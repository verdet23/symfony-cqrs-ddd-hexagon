<?php

declare(strict_types=1);

namespace App\User\Infrastructure\DBAL\Types;

use App\Shared\Infrastructure\DBAL\Types\AbstractUuid;
use App\User\Domain\ValueObject\Uuid;

class UuidType extends AbstractUuid
{
    public function getName(): string
    {
        return Uuid::class;
    }

    protected function getUidClass(): string
    {
        return Uuid::class;
    }
}
