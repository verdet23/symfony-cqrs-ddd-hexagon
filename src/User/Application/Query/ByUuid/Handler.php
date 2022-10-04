<?php

declare(strict_types=1);

namespace App\User\Application\Query\ByUuid;

use App\Shared\Application\Query\Handler as QueryHandler;
use App\User\Domain\Query\Projections\UserView;
use App\User\Domain\Repository\UserRepository;

class Handler implements QueryHandler
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Query $query): UserView
    {
        return $this->repository->oneByUuid($query->uuid);
    }
}
