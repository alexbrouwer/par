<?php

declare(strict_types=1);

namespace PARTest\Core\Unit\ValueType;

use ArrayIterator;
use InvalidArgumentException;
use PAR\Core\ValueType\CollectionType;
use PAR\Core\ValueType\FloatType;
use PAR\Core\ValueType\InstanceOfType;
use PAR\Core\ValueType\IntegerType;
use PAR\Core\ValueType\NullType;
use PAR\Core\ValueType\StringType;
use PAR\Core\ValueType\UnionType;
use PHPUnit\Framework\TestCase;

class CollectionTypeTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function itCannotBeCreatedWithOnlyNullAsValueType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        CollectionType::list(new NullType());
    }

    /**
     * @test
     * @return void
     */
    public function itCannotBeCreatedAsIterableWithUnionTypeAsValueType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        CollectionType::list(new UnionType([new StringType(), new IntegerType()]));
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToUnorderedList(): void
    {
        $type = CollectionType::list(new StringType());

        self::assertEquals('string[]', $type->toString());
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToUnorderedTypedList(): void
    {
        $type = CollectionType::list(new StringType(), new InstanceOfType(ArrayIterator::class));

        self::assertEquals(ArrayIterator::class . '<string>', $type->toString());
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToUnorderedArray(): void
    {
        $type = CollectionType::array(new StringType());

        self::assertEquals('array<string>', $type->toString());
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToArrayMap(): void
    {
        $type = CollectionType::array(new UnionType([new IntegerType(), new FloatType()]), new StringType());

        self::assertEquals('array<string,float|int>', $type->toString());
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToNestedArrayMap(): void
    {
        $type = CollectionType::array(CollectionType::array(new IntegerType(), new FloatType()), new StringType());

        self::assertEquals('array<string,array<float,int>>', $type->toString());
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToMap(): void
    {
        $type = CollectionType::map(
            new InstanceOfType(ArrayIterator::class),
            new StringType(),
            new UnionType([new IntegerType(), new FloatType()])
        );

        self::assertEquals(ArrayIterator::class . '<string,float|int>', $type->toString());
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToNestedMap(): void
    {
        $type = CollectionType::map(
            new InstanceOfType(ArrayIterator::class),
            new StringType(),
            CollectionType::array(new IntegerType(), new FloatType())
        );

        self::assertEquals(ArrayIterator::class . '<string,array<float,int>>', $type->toString());
    }

    /**
     * @test
     * @return void
     */
    public function itCanTestValueIsExpectedList(): void
    {
        $type = CollectionType::list(new StringType());

        self::assertTrue($type->test(new ArrayIterator([])));
        self::assertTrue($type->test([]));
        self::assertTrue($type->test(['value1', 'value2']));

        self::assertFalse($type->test([1]));
        self::assertFalse($type->test(['value1', false]));
    }

    /**
     * @test
     * @return void
     */
    public function itCanTestValueIsExpectedMap(): void
    {
        $type = CollectionType::map(new InstanceOfType(ArrayIterator::class), new StringType(), new StringType());

        self::assertTrue($type->test(new ArrayIterator([])));
        self::assertTrue($type->test(new ArrayIterator(['key' => 'value'])));

        self::assertFalse($type->test([]));
        self::assertFalse($type->test(new ArrayIterator(['value'])));
        self::assertFalse($type->test(new ArrayIterator([1 => 'value'])));
        self::assertFalse($type->test(new ArrayIterator(['key' => 1])));
    }

    /**
     * @test
     * @return void
     */
    public function itCanTestValueIsExpectedArray(): void
    {
        $type = CollectionType::array(new IntegerType());

        self::assertTrue($type->test([]));
        self::assertTrue($type->test([1, 2]));

        self::assertFalse($type->test(new ArrayIterator([1, 2])));
        self::assertFalse($type->test(['value1']));
        self::assertFalse($type->test([1, 'value1', false]));
    }
}
