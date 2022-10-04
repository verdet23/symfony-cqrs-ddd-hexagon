<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Infrastructure\Query\Postgre;

use App\User\Domain\Security\UserPasswordHasher;
use App\User\Domain\ValueObject\DisplayName;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\PlainPassword;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;
use App\User\Infrastructure\Fixtures\User as UserFixture;
use App\User\Infrastructure\Query\Postgre\Users;
use App\User\Infrastructure\Query\Projections\UserView as UserImpl;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UsersTest extends KernelTestCase
{
    private Users $repository;
    private UserPasswordHasher $hasher;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $this->repository = $container->get('app.user.repository');
        $this->hasher = $container->get('app.user.security.hasher');

        parent::setUp();
    }

    public function testSave(): void
    {
        $item = UserImpl::create(
            Uuid::fromString('bc92b479-a29c-42bd-afca-ec2d41f4a479'),
            Email::fromString('sburns@example.com'),
            Username::fromString('sburns'),
            DisplayName::fromString('Steve Burns'),
            $this->hasher->hashPassword(PlainPassword::fromString('ec2d41f4a479')),
            new DateTimeImmutable()
        );

        $this->repository->save($item);

        $checkItem = $this->repository->oneByUuid(Uuid::fromString('bc92b479-a29c-42bd-afca-ec2d41f4a479'));

        $this->assertSame($item->uuid(), $checkItem->uuid());
        $this->assertSame($item->email(), $checkItem->email());
        $this->assertSame($item->username(), $checkItem->username());
        $this->assertSame($item->displayName(), $checkItem->displayName());
    }

    public function testOneByUuid(): void
    {
        $item = $this->repository->oneByUuid(Uuid::fromString(UserFixture::USER_ONE_UUID));

        $this->assertSame(UserFixture::USER_ONE_UUID, $item->uuid()->toString());
    }

    public function testOneByUuidNotFound(): void
    {
        $this->expectException(\Exception::class);

        $this->repository->oneByUuid(Uuid::fromString('ff6de3ba-b737-422a-b6ed-2b812cc4ce0e'));
    }

    public function testOneByEmail(): void
    {
        $item = $this->repository->oneByEmail(Email::fromString(UserFixture::USER_ONE_EMAIL));

        $this->assertSame(UserFixture::USER_ONE_EMAIL, $item->email()->toString());
    }

    public function testOneByEmailNotFound(): void
    {
        $this->expectException(\Exception::class);

        $this->repository->oneByEmail(Email::fromString('rnd@example.com'));
    }

    public function testOneByUsername(): void
    {
        $item = $this->repository->oneByUsername(Username::fromString(UserFixture::USER_ONE_USERNAME));

        $this->assertSame(UserFixture::USER_ONE_USERNAME, $item->username()->toString());
    }

    public function testOneByUsernameNotFound(): void
    {
        $this->expectException(\Exception::class);

        $this->repository->oneByUsername(Username::fromString('rndcom'));
    }

    /**
     * @dataProvider dataProviderExistsEmail
     */
    public function testExistsEmail(Email $email, bool $expected): void
    {
        $result = $this->repository->existsEmail($email);

        $this->assertSame($expected, $result);
    }

    /**
     * @return list<array{0: Email, 1: bool}>
     */
    public function dataProviderExistsEmail(): array
    {
        return [
            [
                Email::fromString('akirkland@example.com'),
                true,
            ],
            [
                Email::fromString('smail@example.com'),
                false,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderExistsUsername
     */
    public function testExistsUsername(Username $username, bool $expected): void
    {
        $result = $this->repository->existsUsername($username);

        $this->assertSame($expected, $result);
    }

    /**
     * @return list<array{0: Username, 1: bool}>
     */
    public function dataProviderExistsUsername(): array
    {
        return [
            [
                Username::fromString('akirkland'),
                true,
            ],
            [
                Username::fromString('smail'),
                false,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderExistsUuid
     */
    public function testExistsUuid(Uuid $uuid, bool $expected): void
    {
        $result = $this->repository->existsUuid($uuid);

        $this->assertSame($expected, $result);
    }

    /**
     * @return list<array{0: Uuid, 1: bool}>
     */
    public function dataProviderExistsUuid(): array
    {
        return [
            [
                Uuid::fromString(UserFixture::USER_ONE_UUID),
                true,
            ],
            [
                Uuid::fromString('b3856563-4763-4704-8dd5-0700b962431c'),
                false,
            ],
        ];
    }
}
