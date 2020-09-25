<?php

declare(strict_types=1);

namespace PARTest\Core\Unit\ValueType;

use PAR\Core\ValueType\MixedType;
use PHPUnit\Framework\TestCase;
use stdClass;

class MixedTypeTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function itCanTestValues(): void
    {
        $type = new MixedType();

        self::assertTrue($type->test(true));
        self::assertTrue($type->test(''));
        self::assertTrue($type->test(1));
        self::assertTrue($type->test(0.0));
        self::assertTrue($type->test(new stdClass()));
        self::assertFalse($type->test(null));
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToString(): void
    {
        $type = new MixedType();

        self::assertEquals('mixed', $type->toString());
    }
}
