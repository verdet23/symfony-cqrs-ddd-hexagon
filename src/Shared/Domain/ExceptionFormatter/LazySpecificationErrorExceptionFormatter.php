<?php

declare(strict_types=1);

namespace App\Shared\Domain\ExceptionFormatter;

use App\Shared\Domain\Exception\InvalidExceptionForFormatterPassedException;
use App\Shared\Domain\Exception\LazySpecificationErrorException;
use Throwable;

final class LazySpecificationErrorExceptionFormatter implements ExceptionFormatter
{
    public function format(Throwable $exception): array
    {
        if (LazySpecificationErrorException::class !== \get_class($exception)) {
            throw InvalidExceptionForFormatterPassedException::create(LazySpecificationErrorException::class, $exception);
        }
        /** @var LazySpecificationErrorException $exception */
        $errors = [];

        foreach ($exception->getErrorExceptions() as $errorException) {
            $errorMessage = [
                'value' => $errorException->value(),
                'message' => $errorException->baseMessage(),
            ];

            if ($errorException->propertyPath()) {
                $errors[$errorException->propertyPath()][] = $errorMessage;
            } else {
                $errors[] = $errorMessage;
            }
        }

        return $errors;
    }

    public function isSuitable(Throwable $exception): bool
    {
        return LazySpecificationErrorException::class === \get_class($exception);
    }
}
