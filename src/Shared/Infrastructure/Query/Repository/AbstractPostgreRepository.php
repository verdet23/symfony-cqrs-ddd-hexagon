<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Query\Repository;

use App\Shared\Domain\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

abstract class AbstractPostgreRepository
{
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(mixed $item): void
    {
        $this->entityManager->persist($item);
        $this->entityManager->flush();
    }

    protected function oneOrException(QueryBuilder $queryBuilder): mixed
    {
        $model = $queryBuilder
            ->getQuery()
            ->getOneOrNullResult();

        if (null === $model) {
            throw NotFoundException::create();
        }

        return $model;
    }
}
