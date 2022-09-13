<?php

declare(strict_types=1);

namespace App\User\Application\Query\ByUuid;

use App\User\Domain\ValueObject\Uuid;

class Query
{
    public Uuid $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = Uuid::fromString($uuid);
    }
}
