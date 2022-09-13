<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class AbstractEmail extends AbstractString
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 320;

        return $platform->getStringTypeDeclarationSQL($column);
    }
}
