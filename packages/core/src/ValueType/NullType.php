<?php

declare(strict_types=1);

namespace PAR\Core\ValueType;

use PAR\Core\ValueType;

/**
 * @internal
 */
final class NullType extends ValueType
{

    public function test($value): bool
    {
        return $value === null;
    }

    public function toString(): string
    {
        return 'null';
    }
}
