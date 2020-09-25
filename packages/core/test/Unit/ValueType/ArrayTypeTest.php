<?php

declare(strict_types=1);

namespace PARTest\Core\Unit\ValueType;

use PAR\Core\ValueType\ArrayType;
use PHPUnit\Framework\TestCase;

class ArrayTypeTest extends TestCase
{

    public function provideValueTests(): array
    {
        return [
            'array' => [[], true],
            'boolean' => [false, false],
            'string' => ['', false],
            'int' => [1, false],
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
        $type = new ArrayType();

        self::assertEquals($test, $type->test($value));
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToString(): void
    {
        $type = new ArrayType();

        self::assertEquals('array', $type->toString());
    }
}
