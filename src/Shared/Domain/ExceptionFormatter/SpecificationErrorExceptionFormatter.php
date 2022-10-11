<?php

declare(strict_types=1);

namespace App\Shared\Domain\ExceptionFormatter;

use App\Shared\Domain\Exception\InvalidExceptionForFormatterPassedException;
use App\Shared\Domain\Exception\SpecificationErrorException;
use Throwable;

final class SpecificationErrorExceptionFormatter implements ExceptionFormatter
{
    public function format(Throwable $exception): array
    {
        if (SpecificationErrorException::class !== \get_class($exception)) {
            throw InvalidExceptionForFormatterPassedException::create(SpecificationErrorException::class, $exception);
        }
        /** @var SpecificationErrorException $exception */
        $errorMessage = [
            'value' => $exception->value(),
            'message' => $exception->baseMessage(),
        ];

        if ($exception->propertyPath()) {
            $errorMessage = [
                $exception->propertyPath() => $errorMessage,
            ];
        }

        return $errorMessage;
    }

    public function isSuitable(Throwable $exception): bool
    {
        return SpecificationErrorException::class === \get_class($exception);
    }
}
