<?php

declare(strict_types=1);

namespace App\Shared\Domain\Specification;

abstract class AbstractSpecification
{
    abstract public function lazy(): AbstractLazySpecification;
}
