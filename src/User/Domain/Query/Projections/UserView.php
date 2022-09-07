<?php

declare(strict_types=1);

namespace App\User\Domain\Query\Projections;

use App\User\Domain\ValueObject\DisplayedName;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;

interface UserView
{
    public function getUuid(): Uuid;

    public function getEmail(): Email;

    public function getUsername(): Username;

    public function getDisplayedName(): DisplayedName;
}
