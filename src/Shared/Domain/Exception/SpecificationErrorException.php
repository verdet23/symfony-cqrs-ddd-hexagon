<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use InvalidArgumentException;

final class SpecificationErrorException extends InvalidArgumentException
{
    private ?string $propertyPath;

    private mixed $value;

    private string $baseMessage;

    private function __construct(string $message = '')
    {
        parent::__construct($message);
    }

    public static function create(string $message, string $path = null, mixed $value = null): self
    {
        $errorMessage = $message;

        if (null !== $path) {
            $errorMessage = sprintf('Specification error "%s" at [%s]', $message, $path);
        }

        $item = new self($errorMessage);
        $item->baseMessage = $message;
        $item->propertyPath = $path;
        $item->value = $value;

        return $item;
    }

    public function propertyPath(): ?string
    {
        return $this->propertyPath;
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function baseMessage(): string
    {
        return $this->baseMessage;
    }
}
