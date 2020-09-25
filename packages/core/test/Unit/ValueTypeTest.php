<?php

declare(strict_types=1);

namespace PARTest\Core\Unit;

use ArrayIterator;
use InvalidArgumentException;
use PAR\Core\ValueType;
use PAR\Core\ValueType as ValueTypes;
use PHPUnit\Framework\TestCase;

class ValueTypeTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function itCannotCreateNullAlone(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ValueType::of('null');
    }

    /**
     * @test
     * @return void
     */
    public function itCannotCreateFromEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ValueType::of('');
    }

    public function provideTypeToClassMap(): array
    {
        return [
            ['string', ValueTypes\StringType::class],
            ['int', ValueTypes\IntegerType::class],
            ['integer', ValueTypes\IntegerType::class],
            ['float', ValueTypes\FloatType::class],
            ['double', ValueTypes\FloatType::class],
            ['object', ValueTypes\ObjectType::class],
            ['resource', ValueTypes\ResourceType::class],
            ['bool', ValueTypes\BooleanType::class],
            ['boolean', ValueTypes\BooleanType::class],
            ['array', ValueTypes\ArrayType::class],
            ['callable', ValueTypes\CallableType::class],
            ['iterable', ValueTypes\IterableType::class],
            ['scalar', ValueTypes\ScalarType::class],
            ['mixed', ValueTypes\MixedType::class],
        ];
    }

    /**
     * @test
     * @dataProvider provideTypeToClassMap
     *
     * @param string $requestedType
     * @param string $expectedInstance
     *
     * @return void
     */
    public function itCreatesExpectedType(string $requestedType, string $expectedInstance): void
    {
        $type = ValueType::of($requestedType);

        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf($expectedInstance, $type);
    }

    /**
     * @test
     * @return void
     */
    public function itCreatesUnionTypeOfNullableString(): void
    {
        $type = ValueType::of('?string');

        self::assertInstanceOf(ValueTypes\UnionType::class, $type);
        self::assertEquals('?string', $type->toString());
    }

    /**
     * @test
     * @return void
     */
    public function itCreatesUnionTypeOfPipedString(): void
    {
        $type = ValueType::of('string|null|int');

        self::assertInstanceOf(ValueTypes\UnionType::class, $type);
        self::assertEquals(['int', 'string', 'null'], explode('|', $type->toString()));
    }

    /**
     * @test
     * @return void
     */
    public function itCreatesCollectionTypeForUnorderedIterable(): void
    {
        $type = ValueType::of('string[]');

        self::assertInstanceOf(ValueTypes\CollectionType::class, $type);
    }

    /**
     * @test
     * @return void
     */
    public function itCreatesCollectionTypeForUnorderedArray(): void
    {
        $type = ValueType::of('array<string>');

        self::assertInstanceOf(ValueTypes\CollectionType::class, $type);
    }

    /**
     * @test
     * @return void
     */
    public function itCreatesCollectionTypeForArrayMap(): void
    {
        $type = ValueType::of('array<string,string>');

        self::assertInstanceOf(ValueTypes\CollectionType::class, $type);
    }

    /**
     * @test
     * @return void
     */
    public function itCreatesCollectionTypeForComplexArrayMap(): void
    {
        $type = ValueType::of('array<string, array<int, string|int> >');

        self::assertInstanceOf(ValueTypes\CollectionType::class, $type);
    }

    /**
     * @test
     * @return void
     */
    public function itCreatesCollectionTypeForUnorderedList(): void
    {
        $type = ValueType::of(ArrayIterator::class . '<string>');

        self::assertInstanceOf(ValueTypes\CollectionType::class, $type);
    }

    /**
     * @test
     * @return void
     */
    public function itCreatesCollectionTypeForMap(): void
    {
        $type = ValueType::of(ArrayIterator::class . '<string, int>');

        self::assertInstanceOf(ValueTypes\CollectionType::class, $type);
    }
}
