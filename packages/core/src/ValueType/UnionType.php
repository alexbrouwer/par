<?php

declare(strict_types=1);

namespace PAR\Core\ValueType;

use InvalidArgumentException;
use PAR\Core\ValueType;

/**
 * @internal
 */
final class UnionType extends ValueType
{
    /**
     * @var ValueType[]
     */
    private array $valueTypes = [];

    private ?NullType $nullable = null;

    /**
     * @param iterable $valueTypes
     */
    public function __construct(iterable $valueTypes)
    {
        foreach ($valueTypes as $valueType) {
            if ($valueType instanceof NullType) {
                $this->nullable = $valueType;
                continue;
            }

            $this->valueTypes[$valueType->toString()] = $valueType;
        }

        if (count($this->valueTypes) + ($this->nullable ? 1 : 0) <= 1) {
            throw new InvalidArgumentException('An UnionType must have at least 2 types');
        }

        ksort($this->valueTypes);
    }

    public function test($value): bool
    {
        if ($this->nullable && $this->nullable->test($value)) {
            return true;
        }

        foreach ($this->valueTypes as $valueType) {
            if ($valueType->test($value)) {
                return true;
            }
        }

        return false;
    }

    public function toString(): string
    {
        $types = array_map(
            static function (ValueType $valueType): string {
                return $valueType->toString();
            },
            $this->valueTypes
        );

        if ($this->nullable) {
            if (count($types) === 1) {
                return sprintf('?%s', reset($types));
            }

            $types[] = $this->nullable->toString();
        }

        return implode('|', $types);
    }
}
