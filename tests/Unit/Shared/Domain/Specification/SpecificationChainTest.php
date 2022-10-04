<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\Specification;

use App\Shared\Domain\Specification\AbstractSpecification;
use App\Shared\Domain\Specification\SpecificationChain;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class SpecificationChainTest extends TestCase
{
    public function testMethodCall(): void
    {
        $specification = $this->getMockBuilder(AbstractSpecification::class)
            ->addMethods(['valueCheck'])
            ->getMockForAbstractClass();

        $specification->expects($this->once())
            ->method('valueCheck')
            ->with('someVal', 'addParam')
            ->willReturn(true);

        $chain = new SpecificationChain('someVal');
        $chain->setSpecification($specification);

        $chain->valueCheck('addParam');
    }

    public function testMethodNotExist(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Specification "valueCheck" does not exist.');

        $specification = $this->getMockForAbstractClass(AbstractSpecification::class);

        $chain = new SpecificationChain('someVal');
        $chain->setSpecification($specification);

        $chain->valueCheck('addParam');
    }
}
