<?php

declare(strict_types=1);

namespace PAR\Core\ValueType;

use PAR\Core\ValueType;

/**
 * @internal
 */
final class ArrayType extends ValueType
{

    public function test($value): bool
    {
        return is_array($value);
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return 'array';
    }
}
