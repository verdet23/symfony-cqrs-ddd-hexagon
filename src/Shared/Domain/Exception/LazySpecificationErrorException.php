<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use InvalidArgumentException;

final class LazySpecificationErrorException extends InvalidArgumentException
{
    /**
     * @var SpecificationErrorException[]
     */
    private array $errors;

    /**
     * @param SpecificationErrorException[] $errors
     */
    private function __construct(string $message, array $errors)
    {
        parent::__construct($message);

        $this->errors = $errors;
    }

    /**
     * @param SpecificationErrorException[] $errors
     */
    public static function fromErrors(array $errors): self
    {
        $message = sprintf('The following %d assertions failed:', \count($errors))."\n";

        $i = 1;
        foreach ($errors as $error) {
            $message .= sprintf("%d) %s: %s\n", $i++, $error->propertyPath(), $error->getMessage());
        }

        return new self($message, $errors);
    }

    /**
     * @return SpecificationErrorException[]
     */
    public function getErrorExceptions(): array
    {
        return $this->errors;
    }
}
