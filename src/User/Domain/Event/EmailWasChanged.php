<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\Shared\Domain\Event;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Uuid;

final class EmailWasChanged extends Event
{
    public Uuid $uuid;

    public Email $email;

    private function __construct()
    {
    }

    public static function create(Uuid $uuid, Email $email): self
    {
        $item = new self();
        $item->uuid = $uuid;
        $item->email = $email;

        return $item;
    }
}
