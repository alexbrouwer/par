<?php

declare(strict_types=1);

namespace PAR\Core\ValueType;

use InvalidArgumentException;
use PAR\Core\ValueType;

/**
 * @internal
 */
final class InstanceOfType extends ValueType
{

    /**
     * @var string
     */
    private string $type;

    /**
     * @param string $type
     */
    public function __construct(string $type)
    {
        if (!class_exists($type)) {
            throw new InvalidArgumentException(sprintf('Class "%s" does not exist or could not be loaded', $type));
        }
        $this->type = $type;
    }

    /**
     * @inheritDoc
     */
    public function test($value): bool
    {
        return $value instanceof $this->type;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return $this->type;
    }
}
