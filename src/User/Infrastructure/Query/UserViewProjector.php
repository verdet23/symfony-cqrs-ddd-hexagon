<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Query;

use App\User\Domain\Event\EmailWasChanged;
use App\User\Domain\Event\PasswordWasChanged;
use App\User\Domain\Event\UserWasCreated;
use App\User\Domain\Query\UserViewFactory as Factory;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\UserProjector;

class UserViewProjector implements UserProjector
{
    private Factory $factory;

    private UserRepository $repository;

    public function __construct(Factory $factory, UserRepository $repository)
    {
        $this->factory = $factory;
        $this->repository = $repository;
    }

    public function applyUserWasCreated(UserWasCreated $event): void
    {
        $userView = $this->factory->create($event->uuid, $event->email, $event->username, $event->displayName, $event->hashedPassword, $event->createdAt);

        $this->repository->add($userView);
    }

    public function applyEmailWasChanged(EmailWasChanged $event): void
    {
        $userView = $this->repository->byUuid($event->uuid);
        $userView->setEmail($event->email);

        $this->repository->add($userView);
    }

    public function applyPasswordWasChanged(PasswordWasChanged $event): void
    {
        $userView = $this->repository->byUuid($event->uuid);
        $userView->setHashedPassword($event->hashedPassword);

        $this->repository->add($userView);
    }
}
