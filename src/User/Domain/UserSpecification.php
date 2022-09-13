<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\Shared\Domain\Exception\SpecificationErrorException;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;

final class UserSpecification
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function isSatisfiedEmail(Email $email): void
    {
        $exist = $this->repository->existsEmail($email);

        if ($exist) {
            throw SpecificationErrorException::create(sprintf('Email %s already exist', $email->toString()), 'email');
        }
    }

    public function isSatisfiedUuid(Uuid $uuid): void
    {
        $exist = $this->repository->existsUuid($uuid);

        if ($exist) {
            throw SpecificationErrorException::create(sprintf('Uuid %s already exist', $uuid->toString()), 'uuid');
        }
    }

    public function isSatisfiedUsername(Username $username): void
    {
        $exist = $this->repository->existsUsername($username);

        if ($exist) {
            throw SpecificationErrorException::create(sprintf('Username %s already exist', $username->toString()), 'uuid');
        }
    }
}
