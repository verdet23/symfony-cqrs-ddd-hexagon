<?php

declare(strict_types=1);

namespace App\User\Application\Command\SignUp;

use App\Shared\Application\Command\Handler as CommandHandler;
use App\User\Domain\UserFactory;

class Handler implements CommandHandler
{
    private UserFactory $factory;

    public function __construct(UserFactory $factory)
    {
        $this->factory = $factory;
    }

    public function __invoke(Command $command): void
    {
        $user = $this->factory->create($command->uuid, $command->email, $command->username, $command->displayName, $command->plainPassword);

        $user->signUp();
    }
}
