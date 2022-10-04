<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\Query\Projections\UserView;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;

interface UserRepository
{
    public function save(UserView $user): void;

    public function oneByUuid(Uuid $uuid): UserView;

    public function oneByEmail(Email $email): UserView;

    public function oneByUsername(Username $username): UserView;
}
