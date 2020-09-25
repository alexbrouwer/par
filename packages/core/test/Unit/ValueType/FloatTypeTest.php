<?php

declare(strict_types=1);

namespace PARTest\Core\Unit\ValueType;

use PAR\Core\ValueType\FloatType;
use PHPUnit\Framework\TestCase;

class FloatTypeTest extends TestCase
{
    public function provideValueTests(): array
    {
        return [
            'float' => [0.0, true],
            'int' => [0, false],
            'string' => ['', false],
        ];
    }

    /**
     * @test
     * @dataProvider provideValueTests
     *
     * @param mixed $value
     * @param bool  $test
     *
     * @return void
     */
    public function itCanTestValues($value, bool $test): void
    {
        $type = new FloatType();

        self::assertEquals($test, $type->test($value));
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToString(): void
    {
        $type = new FloatType();

        self::assertEquals('float', $type->toString());
    }
}
