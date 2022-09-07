<?php

declare(strict_types=1);

namespace App\Blog\Post\Application\Command\Post\Create;

use App\Shared\Application\Command\Handler as CommandHandler;

final class Handler implements CommandHandler
{
    public function __invoke(Command $command): void
    {
    }
}
