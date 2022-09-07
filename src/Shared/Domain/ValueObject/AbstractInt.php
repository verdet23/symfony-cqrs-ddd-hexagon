<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use JsonSerializable;

abstract class AbstractInt implements JsonSerializable
{
    private int $value;

    public static function fromInt(int $value): static
    {
        $item = new static();
        $item->value = $value;

        return $item;
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function jsonSerialize(): int
    {
        return $this->value;
    }

    final private function __construct()
    {
    }
}
