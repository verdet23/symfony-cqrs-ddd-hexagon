<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Query;

use App\User\Domain\Query\Projections\UserView;
use App\User\Domain\Query\UserViewFactory as Factory;
use App\User\Domain\ValueObject\DisplayName;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\HashedPassword;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;
use App\User\Infrastructure\Query\Projections\UserView as UserViewImpl;
use DateTimeImmutable;

class UserViewFactory implements Factory
{
    public function create(Uuid $uuid, Email $email, Username $username, DisplayName $displayName, HashedPassword $hashedPassword, DateTimeImmutable $createdAt): UserView
    {
        return UserViewImpl::create($uuid, $email, $username, $displayName, $hashedPassword, $createdAt);
    }
}
