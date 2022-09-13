<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\Shared\Domain\Event;
use App\User\Domain\ValueObject\HashedPassword;
use App\User\Domain\ValueObject\Uuid;

final class PasswordWasChanged extends Event
{
    public Uuid $uuid;

    public HashedPassword $hashedPassword;

    private function __construct()
    {
    }

    public static function create(Uuid $uuid, HashedPassword $hashedPassword): self
    {
        $item = new self();
        $item->uuid = $uuid;
        $item->hashedPassword = $hashedPassword;

        return $item;
    }
}
