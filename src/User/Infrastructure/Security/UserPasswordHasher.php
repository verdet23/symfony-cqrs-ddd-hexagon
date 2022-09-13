<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Security;

use App\User\Domain\Security\UserPasswordHasher as Hasher;
use App\User\Domain\ValueObject\HashedPassword;
use App\User\Domain\ValueObject\PlainPassword;
use App\User\Infrastructure\Query\Projections\UserView;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

final class UserPasswordHasher implements Hasher
{
    private PasswordHasherInterface $hasher;

    public function __construct(PasswordHasherFactoryInterface $factory)
    {
        $this->hasher = $factory->getPasswordHasher(UserView::class);
    }

    public function hashPassword(PlainPassword $plainPassword): HashedPassword
    {
        return HashedPassword::fromString($this->hasher->hash($plainPassword->toString()));
    }
}
