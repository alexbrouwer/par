<?php

declare(strict_types=1);

namespace PAR\Core\ValueType;

use PAR\Core\ValueType;

/**
 * @internal
 */
final class ScalarType extends ValueType
{

    public function test($value): bool
    {
        return is_scalar($value);
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        // int, float, string, bool
        return 'scalar';
    }
}
