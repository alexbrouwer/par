<?php

declare(strict_types=1);

namespace PAR\Core\ValueType;

use PAR\Core\ValueType;

/**
 * @internal
 */
final class ResourceType extends ValueType
{

    public function test($value): bool
    {
        return is_resource($value) || gettype($value) === 'resource (closed)';
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return 'resource';
    }
}
