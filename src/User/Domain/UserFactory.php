<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\User\Domain\ValueObject\DisplayName;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\PlainPassword;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;

interface UserFactory
{
    public function create(Uuid $uuid, Email $email, Username $username, DisplayName $displayName, PlainPassword $plainPassword): User;

    public function createByUuid(Uuid $uuid): User;
}
