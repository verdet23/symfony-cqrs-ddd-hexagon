<?php

declare(strict_types=1);

namespace App\Shared\Domain\Specification;

use ReflectionException;
use ReflectionMethod;
use RuntimeException;

final class SpecificationChain
{
    private mixed $value;

    private AbstractSpecification $specification;

    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    public function __call(string $methodName, array $args): self
    {
        try {
            new ReflectionMethod($this->specification, $methodName);
        } catch (ReflectionException $exception) {
            throw new RuntimeException(sprintf('Specification "%s" does not exist.', $methodName), 0, $exception);
        }

        array_unshift($args, $this->value);

        \call_user_func_array([$this->specification, $methodName], $args);

        return $this;
    }

    public function setSpecification(AbstractSpecification $specification): self
    {
        $this->specification = $specification;

        return $this;
    }
}
