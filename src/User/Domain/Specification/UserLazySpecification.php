<?php

declare(strict_types=1);

namespace App\User\Domain\Specification;

use App\Shared\Domain\Specification\AbstractLazySpecification;

/**
 * @method UserLazySpecification isSatisfiedEmail()
 * @method UserLazySpecification isSatisfiedUuid()
 * @method UserLazySpecification isSatisfiedUsername()
 */
class UserLazySpecification extends AbstractLazySpecification
{

}
