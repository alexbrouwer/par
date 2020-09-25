<?php

declare(strict_types=1);

namespace PAR\Core\ValueType;

use PAR\Core\ValueType;

/**
 * @internal
 */
final class BooleanType extends ValueType
{

    public function test($value): bool
    {
        return is_bool($value);
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return 'bool';
    }
}
