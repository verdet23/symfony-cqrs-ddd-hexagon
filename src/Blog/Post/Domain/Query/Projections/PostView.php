<?php

declare(strict_types=1);

namespace App\Blog\Post\Domain\Query\Projections;

use App\Blog\Post\Domain\ValueObject\Content;
use App\Blog\Post\Domain\ValueObject\Title;
use App\Blog\Post\Domain\ValueObject\Uuid;

interface PostView
{
    public function getUuid(): Uuid;

    public function getTitle(): Title;

    public function getContent(): Content;
}
