<?php

declare(strict_types=1);

namespace App\User\Infrastructure;

use App\User\Domain\Repository\UserRepository;
use App\User\Domain\Security\UserPasswordHasher;
use App\User\Domain\Specification\UserSpecification;
use App\User\Domain\User;
use App\User\Domain\UserFactory as Factory;
use App\User\Domain\UserProjector;
use App\User\Domain\ValueObject\DisplayName;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\PlainPassword;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;
use DateTimeImmutable;

class UserFactory implements Factory
{
    private UserRepository $repository;

    private UserSpecification $specification;

    private UserPasswordHasher $hasher;

    private UserProjector $projector;

    public function __construct(UserRepository $repository, UserSpecification $specification, UserPasswordHasher $hasher, UserProjector $projector)
    {
        $this->repository = $repository;
        $this->specification = $specification;
        $this->hasher = $hasher;
        $this->projector = $projector;
    }

    public function create(Uuid $uuid, Email $email, Username $username, DisplayName $displayName, PlainPassword $plainPassword): User
    {
        return new User(
            $uuid,
            $email,
            $username,
            $displayName,
            $this->hasher->hashPassword($plainPassword),
            new DateTimeImmutable(),
            $this->specification,
            $this->hasher,
            $this->projector
        );
    }

    public function createByUuid(Uuid $uuid): User
    {
        $userView = $this->repository->oneByUuid($uuid);

        return new User(
            $userView->uuid(),
            $userView->email(),
            $userView->username(),
            $userView->displayName(),
            $userView->hashedPassword(),
            $userView->createdAt(),
            $this->specification,
            $this->hasher,
            $this->projector
        );
    }
}
