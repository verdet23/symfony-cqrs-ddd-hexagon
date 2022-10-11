<?php

declare(strict_types=1);

namespace App\Shared\Domain\ExceptionFormatter;

use App\Shared\Domain\Exception\InvalidExceptionForFormatterPassedException;
use Assert\InvalidArgumentException;
use Throwable;

final class AssertionExceptionFormatter implements ExceptionFormatter
{
    public function format(Throwable $exception): array
    {
        if (InvalidArgumentException::class !== \get_class($exception)) {
            throw InvalidExceptionForFormatterPassedException::create(InvalidArgumentException::class, $exception);
        }
        /** @var InvalidArgumentException $exception */
        $errorMessage = [
            'value' => $exception->getValue(),
            'message' => $exception->getMessage(),
        ];

        if ($exception->getPropertyPath()) {
            $errorMessage = [
                $exception->getPropertyPath() => $errorMessage,
            ];
        }

        return $errorMessage;
    }

    public function isSuitable(Throwable $exception): bool
    {
        return InvalidArgumentException::class === \get_class($exception);
    }
}
