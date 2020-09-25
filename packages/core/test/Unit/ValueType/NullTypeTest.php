<?php

declare(strict_types=1);

namespace PARTest\Core\Unit\ValueType;

use PAR\Core\ValueType\NullType;
use PHPUnit\Framework\TestCase;

class NullTypeTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function itCanTestValues(): void
    {
        $type = new NullType();

        self::assertTrue($type->test(null));
        self::assertFalse($type->test(''));
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToString(): void
    {
        $type = new NullType();

        self::assertEquals('null', $type->toString());
    }
}
