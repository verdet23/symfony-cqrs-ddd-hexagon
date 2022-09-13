<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use InvalidArgumentException;

class SpecificationErrorException extends InvalidArgumentException
{
    private ?string $path;

    private string $baseMessage;

    public static function create(string $message, string $path = null): self
    {
        $errorMessage = $message;

        if (null !== $path) {
            $errorMessage = sprintf('Specification error %s at [%s]', $message, $path);
        }

        $item = new self($errorMessage);
        $item->baseMessage = $message;
        $item->path = $path;

        return $item;
    }

    private function __construct(string $message = '')
    {
        parent::__construct($message);
    }

    public function path(): ?string
    {
        return $this->path;
    }

    public function baseMessage(): string
    {
        return $this->baseMessage;
    }
}
