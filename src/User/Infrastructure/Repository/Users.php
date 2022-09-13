<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Repository;

use App\User\Domain\Query\Projections\UserView;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;
use App\User\Infrastructure\Query\Projections\UserView as UserViewImpl;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class Users implements UserRepository
{
    /**
     * @var EntityRepository<UserViewImpl>
     */
    private EntityRepository $repository;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(UserViewImpl::class);
        $this->entityManager = $entityManager;
    }

    public function add(UserView $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function byUuid(Uuid $uuid): UserView
    {
        $item = $this->repository->findOneBy(['uuid' => $uuid]);

        if (null === $item) {
            throw new \Exception(); // @TODO Specific domain exception
        }

        return $item;
    }

    public function existsEmail(Email $email): bool
    {
        // @TODO SQL query select uuid
        return null !== $this->repository->createQueryBuilder('u')
                ->andWhere('u.email = :email')
                ->setParameter('email', $email->toString())
                ->getQuery()
                ->getOneOrNullResult();
    }

    public function existsUsername(Username $username): bool
    {
        // @TODO SQL query select uuid
        return null !== $this->repository->createQueryBuilder('u')
                ->andWhere('u.username = :username')
                ->setParameter('username', $username->toString())
                ->getQuery()
                ->getOneOrNullResult();
    }

    public function existsUuid(Uuid $uuid): bool
    {
        // @TODO SQL query select uuid
        return null !== $this->repository->createQueryBuilder('u')
                ->andWhere('u.uuid = :uuid')
                ->setParameter('uuid', $uuid->toString())
                ->getQuery()
                ->getOneOrNullResult();
    }
}
