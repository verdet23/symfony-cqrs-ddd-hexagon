<?php

declare(strict_types=1);

namespace App\Blog\Post\Application\Query\Post\ByUuid;

use App\Blog\Post\Domain\ValueObject\Uuid;
use App\Shared\Application\Query\Query as QueryQuery;

class Query implements QueryQuery
{
    public Uuid $uuid;

    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }
}
