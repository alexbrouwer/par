<?php

declare(strict_types=1);

namespace PARTest\Core\Unit\ValueType;

use PAR\Core\ValueType\IntegerType;
use PHPUnit\Framework\TestCase;

class IntegerTypeTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function itCanTestValues(): void
    {
        $type = new IntegerType();

        self::assertTrue($type->test(1));
        self::assertFalse($type->test(''));
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToString(): void
    {
        $type = new IntegerType();

        self::assertEquals('int', $type->toString());
    }
}
