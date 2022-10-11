<?php

declare(strict_types=1);

namespace App\User\Domain\Specification;

use App\Shared\Domain\Exception\SpecificationErrorException;
use App\Shared\Domain\Specification\AbstractSpecification;
use App\User\Domain\Repository\CheckExist;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;

final class UserSpecification extends AbstractSpecification
{
    private CheckExist $repository;

    public function __construct(CheckExist $repository)
    {
        $this->repository = $repository;
    }

    public function isSatisfiedEmail(Email $email): void
    {
        $exist = $this->repository->existsEmail($email);

        if ($exist) {
            throw SpecificationErrorException::create('Email already exist', $email->toString(), 'email');
        }
    }

    public function isSatisfiedUuid(Uuid $uuid): void
    {
        $exist = $this->repository->existsUuid($uuid);

        if ($exist) {
            throw SpecificationErrorException::create('Uuid already exist', $uuid->toString(), 'uuid');
        }
    }

    public function isSatisfiedUsername(Username $username): void
    {
        $exist = $this->repository->existsUsername($username);

        if ($exist) {
            throw SpecificationErrorException::create('Username already exist', $username->toString(), 'username');
        }
    }

    public function lazy(): UserLazySpecification
    {
        return new UserLazySpecification($this);
    }
}
