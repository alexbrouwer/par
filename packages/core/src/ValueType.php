<?php

declare(strict_types=1);

namespace PAR\Core;

use InvalidArgumentException;
use PAR\Core\ValueType as ValueTypes;

abstract class ValueType
{

    public static function of(string $type): self
    {
        $type = str_replace('?', 'null|', $type);

        $types = self::parseTypes($type);

        switch (count($types)) {
            case 1:
                $current = reset($types);
                if (strtolower($current) === 'null') {
                    throw new InvalidArgumentException('A ValueType cannot be only NULL');
                }

                return static::fromName($current);
            case 0:
                throw new InvalidArgumentException('Expected at least a single type');
            default:
                $valueTypes = array_map([static::class, 'fromName'], $types);

                return new ValueTypes\UnionType($valueTypes);
        }
    }

    /**
     * @param string $type
     *
     * @return array
     */
    private static function parseTypes(string $type): array
    {
        $types = [];
        $pos = 0;
        $end = strlen($type) - 1;
        $token = '';
        $groups = 0;
        while ($pos <= $end) {
            $char = $type[$pos];

            if ($groups === 0 && $char === '|') {
                $types[] = $token;
                $token = '';

                // Skip this char
                $pos++;
                continue;
            }

            $token .= $char;

            if ($char === '<') {
                $groups++;
            }
            if ($char === '>') {
                $groups--;
            }

            $pos++;
        }

        if ($token !== '') {
            $types[] = $token;
        }

        $types = array_unique(
            array_filter(
                $types
            )
        );
        return $types;
    }

    public static function fromName(string $name): self
    {
        $simpleTypeMap = [
            'null' => ValueTypes\NullType::class,
            'string' => ValueTypes\StringType::class,
            'int' => ValueTypes\IntegerType::class,
            'integer' => ValueTypes\IntegerType::class,
            'float' => ValueTypes\FloatType::class,
            'double' => ValueTypes\FloatType::class,
            'object' => ValueTypes\ObjectType::class,
            'resource' => ValueTypes\ResourceType::class,
            'bool' => ValueTypes\BooleanType::class,
            'boolean' => ValueTypes\BooleanType::class,
            'array' => ValueTypes\ArrayType::class,
            'callable' => ValueTypes\CallableType::class,
            'iterable' => ValueTypes\IterableType::class,
            'scalar' => ValueTypes\ScalarType::class,
            'mixed' => ValueTypes\MixedType::class,
        ];

        $type = strtolower($name);

        if (!isset($simpleTypeMap[$type])) {
            if (strpos($name, '[') !== false || strpos($name, '<') !== false) {
                if (preg_match('/^([a-zA-Z0-9\\-_]+)\[\]$/', $name, $matches)) {
                    $valueType = static::of(trim($matches[1]));

                    return ValueTypes\CollectionType::list($valueType);
                }

                if (preg_match('/^([a-zA-Z0-9\\-_]+)<(.+)>$/', $name, $matches)) {
                    $listType = static::of(trim($matches[1]));

                    $parts = explode(',', $matches[2], 2);
                    if (count($parts) === 1) {
                        return ValueTypes\CollectionType::list(static::of(trim($parts[0])), $listType);
                    }

                    return ValueTypes\CollectionType::map($listType, static::of(trim($parts[0])), static::of(trim($parts[1])));
                }
            }

            // class
            return new ValueTypes\InstanceOfType($name);
        }

        return new $simpleTypeMap[$type]();
    }

    /**
     * Test if provided value is of this type.
     *
     * @param mixed $value The value to test
     *
     * @return bool True if provided value is of this type
     */
    abstract public function test($value): bool;

    /**
     * Returns a string representation of this type.
     *
     * @return string
     */
    abstract public function toString(): string;
}
