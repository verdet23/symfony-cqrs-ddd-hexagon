<?php

declare(strict_types=1);

namespace App\Shared\Domain\ExceptionFormatter;

use Throwable;

interface ExceptionFormatter
{
    public function format(Throwable $exception): array;

    public function isSuitable(Throwable $exception): bool;
}
