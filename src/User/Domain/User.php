<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\User\Domain\Event\EmailWasChanged;
use App\User\Domain\Event\PasswordWasChanged;
use App\User\Domain\Event\UserWasCreated;
use App\User\Domain\Security\UserPasswordHasher;
use App\User\Domain\Specification\UserSpecification;
use App\User\Domain\ValueObject\DisplayName;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\HashedPassword;
use App\User\Domain\ValueObject\PlainPassword;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;
use DateTimeImmutable;

final class User
{
    private Uuid $uuid;

    private Email $email;

    private Username $username;

    private DisplayName $displayName;

    private HashedPassword $hashedPassword;

    private DateTimeImmutable $createdAt;

    private UserSpecification $specification;

    private UserPasswordHasher $hasher;

    private UserProjector $projector;

    public function __construct(Uuid $uuid, Email $email, Username $username, DisplayName $displayName, HashedPassword $hashedPassword, DateTimeImmutable $createdAt, UserSpecification $specification, UserPasswordHasher $hasher, UserProjector $projector)
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->username = $username;
        $this->displayName = $displayName;
        $this->hashedPassword = $hashedPassword;
        $this->createdAt = $createdAt;
        $this->specification = $specification;
        $this->hasher = $hasher;
        $this->projector = $projector;
    }

    public function signUp(): void
    {
        $this->specification->isSatisfiedUuid($this->uuid);
        $this->specification->isSatisfiedEmail($this->email);
        $this->specification->isSatisfiedUsername($this->username);

        $event = UserWasCreated::create($this->uuid, $this->email, $this->username, $this->displayName, $this->hashedPassword, $this->createdAt);

        $this->projector->applyUserWasCreated($event);
    }

    public function changePassword(PlainPassword $password): void
    {
        $this->hashedPassword = $this->hasher->hashPassword($password);

        $this->projector->applyPasswordWasChanged(PasswordWasChanged::create($this->uuid, $this->hashedPassword));
    }

    public function changeEmail(Email $email): void
    {
        $this->specification->isSatisfiedEmail($email);

        $this->email = $email;

        $this->projector->applyEmailWasChanged(EmailWasChanged::create($this->uuid, $this->email));
    }
}
