<?php

declare(strict_types=1);

namespace PAR\Core\ValueType;

use PAR\Core\ValueType;

/**
 * @internal
 */
final class StringType extends ValueType
{

    public function test($value): bool
    {
        return is_string($value);
    }

    public function toString(): string
    {
        return 'string';
    }
}
