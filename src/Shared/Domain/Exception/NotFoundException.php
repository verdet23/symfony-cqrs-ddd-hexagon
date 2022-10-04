<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use Exception;
use Throwable;

final class NotFoundException extends Exception
{
    public static function create(): self
    {
        return new self('Resource not found');
    }

    private function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
