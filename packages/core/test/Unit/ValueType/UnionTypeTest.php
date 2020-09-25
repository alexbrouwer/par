<?php

declare(strict_types=1);

namespace PARTest\Core\Unit\ValueType;

use InvalidArgumentException;
use PAR\Core\ValueType;
use PHPUnit\Framework\TestCase;

class UnionTypeTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function itCannotBeCreatedWithNoTypes(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ValueType\UnionType([]);
    }

    /**
     * @test
     * @return void
     */
    public function itCannotBeCreatedWithOneType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ValueType\UnionType([new ValueType\StringType(), new ValueType\StringType()]);
    }

    /**
     * @test
     * @return void
     */
    public function itCannotBeCreatedWithOnlyNull(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ValueType\UnionType([new ValueType\NullType()]);
    }

    /**
     * @test
     * @return void
     */
    public function itCanTestValues(): void
    {
        $valueType = $this->createMock(ValueType::class);
        $valueType->expects(self::atLeastOnce())->method('test')->willReturnCallback('is_string');

        $type = new ValueType\UnionType([new ValueType\NullType(), $valueType]);

        self::assertTrue($type->test(null));
        self::assertTrue($type->test(''));
        self::assertFalse($type->test(1));
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToNullableTypeString(): void
    {
        $type = new ValueType\UnionType([new ValueType\NullType(), new ValueType\StringType()]);

        self::assertEquals('?string', $type->toString());
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToPipedString(): void
    {
        $type = new ValueType\UnionType(
            [new ValueType\NullType(), new ValueType\StringType(), new ValueType\IntegerType()]
        );

        self::assertEquals('int|string|null', $type->toString());
    }
}
