<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\User\Domain\Event\EmailWasChanged;
use App\User\Domain\Event\PasswordWasChanged;
use App\User\Domain\Event\UserWasCreated;

interface UserProjector
{
    public function applyUserWasCreated(UserWasCreated $event): void;

    public function applyEmailWasChanged(EmailWasChanged $event): void;

    public function applyPasswordWasChanged(PasswordWasChanged $event): void;
}
