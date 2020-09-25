<?php

declare(strict_types=1);

namespace PARTest\Core\Unit\ValueType;

use PAR\Core\ValueType\StringType;
use PHPUnit\Framework\TestCase;

class StringTypeTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function itCanTestValues(): void
    {
        $type = new StringType();

        self::assertTrue($type->test(''));
        self::assertFalse($type->test(1));
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToString(): void
    {
        $type = new StringType();

        self::assertEquals('string', $type->toString());
    }
}
