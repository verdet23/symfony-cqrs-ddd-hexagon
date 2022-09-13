<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\Query\Projections\UserView;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;

interface UserRepository
{
    public function add(UserView $user): void;

    public function byUuid(Uuid $uuid): UserView;

    public function existsEmail(Email $email): bool;

    public function existsUsername(Username $username): bool;

    public function existsUuid(Uuid $uuid): bool;
}
