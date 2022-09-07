<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use JsonSerializable;

abstract class AbstractString implements JsonSerializable
{
    protected string $value;

    public static function fromString(string $value): static
    {
        $item = new static();
        $item->value = $value;

        $item->validate();

        return $item;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function jsonSerialize(): string
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
