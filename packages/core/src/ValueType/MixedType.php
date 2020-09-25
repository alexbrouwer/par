<?php

declare(strict_types=1);

namespace PAR\Core\ValueType;

use PAR\Core\ValueType;

/**
 * @internal
 */
final class MixedType extends ValueType
{

    public function test($value): bool
    {
        return $value !== null;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return 'mixed';
    }
}
