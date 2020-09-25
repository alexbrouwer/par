<?php

declare(strict_types=1);

namespace PAR\Core\ValueType;

use PAR\Core\ValueType;

/**
 * @internal
 */
final class FloatType extends ValueType
{

    public function test($value): bool
    {
        return is_float($value);
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return 'float';
    }
}
