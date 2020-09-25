<?php

declare(strict_types=1);

namespace PARTest\Core\Unit\ValueType;

use PAR\Core\ValueType\BooleanType;
use PHPUnit\Framework\TestCase;

class BooleanTypeTest extends TestCase
{

    public function provideValueTests(): array
    {
        return [
            'boolean-true' => [true, true],
            'boolean-false' => [false, true],
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
        $type = new BooleanType();

        self::assertEquals($test, $type->test($value));
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToString(): void
    {
        $type = new BooleanType();

        self::assertEquals('bool', $type->toString());
    }
}
