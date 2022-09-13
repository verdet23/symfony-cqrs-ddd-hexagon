<?php

declare(strict_types=1);

namespace App\User\Domain\Query\Projections;

use App\User\Domain\ValueObject\DisplayName;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\HashedPassword;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;
use DateTimeImmutable;

interface UserView
{
    public function uuid(): Uuid;

    public function email(): Email;

    public function username(): Username;

    public function displayName(): DisplayName;

    public function hashedPassword(): HashedPassword;

    public function createdAt(): DateTimeImmutable;

    public function setEmail(Email $email): static;

    public function setUsername(Username $username): static;

    public function setDisplayName(DisplayName $displayName): static;

    public function setHashedPassword(HashedPassword $hashedPassword): static;
}
