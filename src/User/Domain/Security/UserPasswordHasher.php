<?php

declare(strict_types=1);

namespace App\User\Domain\Security;

use App\User\Domain\ValueObject\HashedPassword;
use App\User\Domain\ValueObject\PlainPassword;

interface UserPasswordHasher
{
    public function hashPassword(PlainPassword $plainPassword): HashedPassword;
}
