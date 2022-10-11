<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Domain\Specification;

use App\Shared\Domain\Exception\LazySpecificationErrorException;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;
use App\User\Infrastructure\Fixtures\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserLazySpecificationTest extends KernelTestCase
{
    public function testLazySpecification(): void
    {
        $this->expectException(LazySpecificationErrorException::class);
        $this->expectExceptionMessage('The following 3 assertions failed:
1) email: Specification error "Email already exist" at [email]
2) uuid: Specification error "Uuid already exist" at [uuid]
3) username: Specification error "Username already exist" at [username]');

        self::bootKernel();

        $container = static::getContainer();

        $specification = $container->get('app.user.specification');

        $specification->lazy()->tryAll()
            ->that(Email::fromString(User::USER_ONE_EMAIL))->isSatisfiedEmail()
            ->that(Uuid::fromString(User::USER_ONE_UUID))->isSatisfiedUuid()
            ->that(Username::fromString(User::USER_ONE_USERNAME))->isSatisfiedUsername()
            ->verifyNow();
    }
}
