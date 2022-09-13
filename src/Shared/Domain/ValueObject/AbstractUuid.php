<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Symfony\Component\Uid\UuidV4;

abstract class AbstractUuid extends UuidV4
{
    final protected function __construct(string $uuid)
    {
        parent::__construct($uuid);
    }

    public function toString(): string
    {
        return $this->__toString();
    }

    public static function generate(): static
    {
        return new static(UuidV4::v4()->__toString());
    }
}
