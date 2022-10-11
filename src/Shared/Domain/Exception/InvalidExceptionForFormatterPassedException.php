<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use InvalidArgumentException;
use Throwable;

final class InvalidExceptionForFormatterPassedException extends InvalidArgumentException
{
    private function __construct(string $message = '')
    {
        parent::__construct($message);
    }

    public static function create(string $expected, Throwable $actual): self
    {
        return new self(sprintf('Unsuitable exception passed for formatter, expected "%s", actual "%s"', $expected, \get_class($actual)));
    }
}
