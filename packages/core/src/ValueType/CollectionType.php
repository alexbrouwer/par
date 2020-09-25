<?php

declare(strict_types=1);

namespace PAR\Core\ValueType;

use InvalidArgumentException;
use PAR\Core\ValueType;

/**
 * @internal
 */
final class CollectionType extends ValueType
{
    private ?ValueType $keyType;

    private ValueType $valueType;

    private ValueType $type;

    public function __construct(ValueType $type, ValueType $valueType, ?ValueType $keyType = null)
    {
        $this->type = $type;
        $this->keyType = $keyType;

        if (!$keyType && $valueType instanceof NullType) {
            throw new InvalidArgumentException('An unordered list cannot have only null as value type');
        }

        $this->valueType = $valueType;
    }

    /**
     * Creates a CollectionType for `valueType[]` or `listType<valueType>`.
     *
     * @param ValueType      $valueType
     * @param ValueType|null $listType
     *
     * @return static
     */
    public static function list(ValueType $valueType, ?ValueType $listType = null): self
    {
        $type = $listType ?? new IterableType();

        if ($type instanceof IterableType && $valueType instanceof UnionType) {
            throw new InvalidArgumentException('An unordered list cannot have a union as type. Create a union of unordered list instead (type[]|type[])');
        }

        return new self($type, $valueType, null);
    }

    /**
     * Creates a CollectionType for `mapType<keyType,valueType>`.
     *
     * @param ValueType $mapType
     * @param ValueType $keyType
     * @param ValueType $valueType
     *
     * @return static
     */
    public static function map(ValueType $mapType, ValueType $keyType, ValueType $valueType): self
    {
        return new self($mapType, $valueType, $keyType);
    }

    /**
     * Creates a CollectionType for `array<valueType>` or `array<keyType,valueType>`.
     *
     * @param ValueType      $valueType The type of value to expect
     * @param ValueType|null $keyType   The type of key to expect. Provide `null` for unordered
     *
     * @return static
     */
    public static function array(ValueType $valueType, ?ValueType $keyType = null): self
    {
        return new self(new ArrayType(), $valueType, $keyType);
    }

    /**
     * @inheritDoc
     */
    public function test($value): bool
    {
        if (!$this->type->test($value)) {
            return false;
        }

        if (!$this->keyType) {
            return $this->testValues($value);
        }

        return $this->testMap($value);
    }

    private function testValues(iterable $items): bool
    {
        foreach ($items as $item) {
            if (!$this->valueType->test($item)) {
                return false;
            }
        }
        return true;
    }

    private function testMap(iterable $values): bool
    {
        foreach ($values as $key => $value) {
            if (!$this->keyType->test($key) || !$this->valueType->test($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        if ($this->type instanceof IterableType) {
            return sprintf('%s[]', $this->valueType->toString());
        }

        $types = [];
        if ($this->keyType) {
            $types[] = $this->keyType->toString();
        }
        $types[] = $this->valueType->toString();

        return sprintf('%s<%s>', $this->type->toString(), implode(',', $types));
    }
}
