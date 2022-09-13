<?php

declare(strict_types=1);

namespace App\User\Domain\Query;

use App\User\Domain\Query\Projections\UserView;
use App\User\Domain\ValueObject\DisplayName;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\HashedPassword;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;
use DateTimeImmutable;

interface UserViewFactory
{
    public function create(Uuid $uuid, Email $email, Username $username, DisplayName $displayName, HashedPassword $hashedPassword, DateTimeImmutable $createdAt): UserView;
}
