<?php

declare(strict_types=1);

namespace PARTest\Core\Unit\ValueType;

use PAR\Core\ValueType\CallableType;
use PHPUnit\Framework\TestCase;

class CallableTypeTest extends TestCase
{
    public function provideValueTests(): array
    {
        return [
            'callable' => [
                static function () {
                },
                true,
            ],
            'callable-array-object' => [[$this, 'itCanTestValues'], true],
            'callable-array-static' => [[TestCase::class, 'assertEquals'], true],
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
        $type = new CallableType();

        self::assertEquals($test, $type->test($value));
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToString(): void
    {
        $type = new CallableType();

        self::assertEquals('callable', $type->toString());
    }
}
