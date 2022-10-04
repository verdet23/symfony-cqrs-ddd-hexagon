<?php

declare(strict_types=1);

namespace App\Shared\Domain\Specification;

use App\Shared\Domain\Exception\LazySpecificationErrorException;
use App\Shared\Domain\Exception\SpecificationErrorException;
use RuntimeException;

abstract class AbstractLazySpecification
{
    /**
     * @var SpecificationErrorException[]
     */
    private array $errors = [];

    private bool $currentChainFailed = false;
    private bool $alwaysTryAll = false;
    private bool $thisChainTryAll = false;
    private ?SpecificationChain $currentChain = null;

    private AbstractSpecification $specification;

    public function __construct(AbstractSpecification $specification)
    {
        $this->specification = $specification;
    }

    public function __call(string $method, array $args): static
    {
        if (false === $this->alwaysTryAll
            && false === $this->thisChainTryAll
            && true === $this->currentChainFailed
        ) {
            return $this;
        }

        if (null === $this->currentChain) {
            throw new RuntimeException('Chain not activated');
        }

        $callable = [$this->currentChain, $method];

        if (!\is_callable($callable)) {
            throw new RuntimeException(sprintf('Method "%s" does not exist in "%s".', $method, \get_class($this->currentChain)));
        }

        try {
            \call_user_func_array($callable, $args);
        } catch (SpecificationErrorException $e) {
            $this->errors[] = $e;
            $this->currentChainFailed = true;
        }

        return $this;
    }

    public function that(mixed $value): static
    {
        $this->currentChainFailed = false;
        $this->thisChainTryAll = false;

        $this->currentChain = new SpecificationChain($value);
        $this->currentChain->setSpecification($this->specification);

        return $this;
    }

    public function tryAll(): static
    {
        if (!$this->currentChain) {
            $this->alwaysTryAll = true;
        }

        $this->thisChainTryAll = true;

        return $this;
    }

    public function verifyNow(): bool
    {
        if ($this->errors) {
            throw LazySpecificationErrorException::fromErrors($this->errors);
        }

        return true;
    }
}
