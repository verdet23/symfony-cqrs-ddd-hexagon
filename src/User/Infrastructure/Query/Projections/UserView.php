<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Query\Projections;

use App\User\Domain\Query\Projections\UserView as UserViewInterface;
use App\User\Domain\ValueObject\DisplayName;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\HashedPassword;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;
use DateTimeImmutable;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserView implements UserViewInterface, UserInterface, PasswordAuthenticatedUserInterface
{
    private Uuid $uuid;

    private Email $email;

    private Username $username;

    private DisplayName $displayName;

    private HashedPassword $hashedPassword;

    private DateTimeImmutable $createdAt;

    public static function create(Uuid $uuid, Email $email, Username $username, DisplayName $displayName, HashedPassword $hashedPassword, DateTimeImmutable $createdAt): self
    {
        $item = new self();
        $item->uuid = $uuid;
        $item->email = $email;
        $item->username = $username;
        $item->displayName = $displayName;
        $item->hashedPassword = $hashedPassword;
        $item->createdAt = $createdAt;

        return $item;
    }

    public function getPassword(): ?string
    {
        return $this->hashedPassword->toString();
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function username(): Username
    {
        return $this->username;
    }

    public function displayName(): DisplayName
    {
        return $this->displayName;
    }

    public function hashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email->toString();
    }

    public function setEmail(Email $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function setUsername(Username $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function setDisplayName(DisplayName $displayName): static
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function setHashedPassword(HashedPassword $hashedPassword): static
    {
        $this->hashedPassword = $hashedPassword;

        return $this;
    }
}
