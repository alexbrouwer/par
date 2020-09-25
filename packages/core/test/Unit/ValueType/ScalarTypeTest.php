<?php

declare(strict_types=1);

namespace PARTest\Core\Unit\ValueType;

use PAR\Core\ValueType\ScalarType;
use PHPUnit\Framework\TestCase;

class ScalarTypeTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function itCanTestValues(): void
    {
        $type = new ScalarType();

        self::assertTrue($type->test(1));
        self::assertTrue($type->test(0.0));
        self::assertTrue($type->test('string'));
        self::assertTrue($type->test(false));

        self::assertFalse($type->test([]));
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToString(): void
    {
        $type = new ScalarType();

        self::assertEquals('scalar', $type->toString());
    }
}
