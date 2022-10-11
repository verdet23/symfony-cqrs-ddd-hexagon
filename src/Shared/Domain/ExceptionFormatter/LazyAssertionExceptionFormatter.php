<?php

declare(strict_types=1);

namespace App\Shared\Domain\ExceptionFormatter;

use App\Shared\Domain\Exception\InvalidExceptionForFormatterPassedException;
use Assert\LazyAssertionException;
use Throwable;

final class LazyAssertionExceptionFormatter implements ExceptionFormatter
{
    public function format(Throwable $exception): array
    {
        if (!$exception instanceof LazyAssertionException) {
            throw InvalidExceptionForFormatterPassedException::create(LazyAssertionException::class, $exception);
        }
        /** @var LazyAssertionException $exception */
        $errors = [];

        foreach ($exception->getErrorExceptions() as $errorException) {
            $errorMessage = [
                'value' => $errorException->getValue(),
                'message' => $errorException->getMessage(),
            ];

            if ($errorException->getPropertyPath()) {
                $errors[$errorException->getPropertyPath()][] = $errorMessage;
            } else {
                $errors[] = $errorMessage;
            }
        }

        return $errors;
    }

    public function isSuitable(Throwable $exception): bool
    {
        return LazyAssertionException::class === \get_class($exception);
    }
}
