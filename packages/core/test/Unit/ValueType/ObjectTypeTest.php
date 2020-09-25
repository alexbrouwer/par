<?php

declare(strict_types=1);

namespace PARTest\Core\Unit\ValueType;

use PAR\Core\ValueType\ObjectType;
use PHPUnit\Framework\TestCase;
use stdClass;

class ObjectTypeTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function itCanTestValues(): void
    {
        $type = new ObjectType();

        self::assertTrue($type->test(new stdClass()));
        self::assertFalse($type->test(''));
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToString(): void
    {
        $type = new ObjectType();

        self::assertEquals('object', $type->toString());
    }
}
