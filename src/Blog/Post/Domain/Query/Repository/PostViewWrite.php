<?php

declare(strict_types=1);

namespace App\Blog\Post\Domain\Query\Repository;

use App\Blog\Post\Domain\Query\Projections\PostView;

interface PostViewWrite
{
    public function add(PostView $item): void;
}
