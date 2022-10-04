<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Query\Postgre;

use App\Shared\Infrastructure\Query\Repository\AbstractPostgreRepository;
use App\User\Domain\Query\Projections\UserView;
use App\User\Domain\Repository\CheckExist;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\Uuid;
use App\User\Infrastructure\Query\Projections\UserView as UserViewImpl;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class Users extends AbstractPostgreRepository implements UserRepository, CheckExist
{
    /**
     * @var EntityRepository<UserViewImpl>
     */
    protected EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->repository = $entityManager->getRepository(UserViewImpl::class);
    }

    public function oneByUuid(Uuid $uuid): UserView
    {
        $queryBuilder = $this->repository
            ->createQueryBuilder('user')
            ->where('user.uuid = :uuid')
            ->setParameter('uuid', $uuid->toString())
        ;

        return $this->oneOrException($queryBuilder);
    }

    public function oneByEmail(Email $email): UserView
    {
        $queryBuilder = $this->repository
            ->createQueryBuilder('user')
            ->where('user.email = :email')
            ->setParameter('email', $email->toString())
        ;

        return $this->oneOrException($queryBuilder);
    }

    public function oneByUsername(Username $username): UserView
    {
        $queryBuilder = $this->repository
            ->createQueryBuilder('user')
            ->where('user.username = :username')
            ->setParameter('username', $username->toString())
        ;

        return $this->oneOrException($queryBuilder);
    }

    public function existsEmail(Email $email): bool
    {
        return $this->existBy('email', $email->toString());
    }

    public function existsUsername(Username $username): bool
    {
        return $this->existBy('username', $username->toString());
    }

    public function existsUuid(Uuid $uuid): bool
    {
        return $this->existBy('uuid', $uuid->toString());
    }

    private function existBy(string $fieldName, mixed $fieldVal): bool
    {
        $item = $this->repository
            ->createQueryBuilder('user')
            ->select('user.uuid')
            ->where(sprintf('user.%s = :param', $fieldName))
            ->setParameter('param', $fieldVal)->getQuery()
            ->setHydrationMode(AbstractQuery::HYDRATE_ARRAY)
            ->getOneOrNullResult();

        return null !== $item;
    }
}
