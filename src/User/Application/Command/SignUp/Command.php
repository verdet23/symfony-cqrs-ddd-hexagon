<?php

declare(strict_types=1);

namespace App\User\Application\Command\SignUp;

use App\Shared\Application\Command\Command as AppCommand;
use App\User\Domain\ValueObject\DisplayName;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\PlainPassword;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;

class Command implements AppCommand
{
    public Uuid $uuid;

    public Email $email;

    public Username $username;

    public DisplayName $displayName;

    public PlainPassword $plainPassword;

    public function __construct(string $uuid, string $email, string $username, string $displayName, string $plainPassword)
    {
        $this->uuid = Uuid::fromString($uuid);
        $this->email = Email::fromString($email);
        $this->username = Username::fromString($username);
        $this->displayName = DisplayName::fromString($displayName);
        $this->plainPassword = PlainPassword::fromString($plainPassword);
    }
}
