<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\User\Domain\Repository\CheckExist;
use App\User\Domain\ValueObject\Uuid;
use RuntimeException;

final class UuidGenerator
{
    private const MAX_ATTEMPTS = 5;

    private CheckExist $repository;

    public function __construct(CheckExist $repository)
    {
        $this->repository = $repository;
    }

    public function generate(): Uuid
    {
        $attempts = 0;
        do {
            $uuid = Uuid::generate();

            if (!$this->repository->existsUuid($uuid)) {
                return $uuid;
            }
            ++$attempts;
        } while ($attempts <= self::MAX_ATTEMPTS);

        throw new RuntimeException('Unable to generate uuid, max attempt count reached');
    }
}
