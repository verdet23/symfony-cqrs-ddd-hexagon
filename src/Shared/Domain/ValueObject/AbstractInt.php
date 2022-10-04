<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use JsonSerializable;

abstract class AbstractInt implements JsonSerializable
{
    protected int $value;

    public static function fromInt(int $value): static
    {
        $item = new static();
        $item->value = $value;

        $item->validate();

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

    protected function validate(): void
    {
    }

    final private function __construct()
    {
    }
}
