<?php

declare(strict_types=1);

namespace App\Blog\Post\Domain\Query\Repository;

use App\Blog\Post\Domain\Query\Projections\PostView;
use App\Blog\Post\Domain\ValueObject\Uuid;

interface PostViewRead
{
    public function byUuid(Uuid $uuid): PostView;
}
