<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Symfony\Component\Uid\UuidV4;

abstract class AbstractUuid extends UuidV4
{
    final private function __construct(string $uuid)
    {
        parent::__construct($uuid);
    }
}
