<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\Shared\Domain\Event;
use App\User\Domain\ValueObject\DisplayName;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\HashedPassword;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;
use DateTimeImmutable;

final class UserWasCreated extends Event
{
    public Uuid $uuid;

    public Email $email;

    public Username $username;

    public DisplayName $displayName;

    public HashedPassword $hashedPassword;

    public DateTimeImmutable $createdAt;

    private function __construct()
    {
    }

    public static function create(Uuid $uuid, Email $email, Username $username, DisplayName $displayName, HashedPassword $hashedPassword, DateTimeImmutable $createdAt): self
    {
        $item = new self();
        $item->uuid = $uuid;
        $item->email = $email;
        $item->username = $username;
        $item->displayName = $displayName;
        $item->hashedPassword = $hashedPassword;
        $item->createdAt = $createdAt;

        return $item;
    }
}
