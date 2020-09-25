<?php

declare(strict_types=1);

namespace PARTest\Core\Unit\ValueType;

use PAR\Core\ValueType\InstanceOfType;
use PHPUnit\Framework\TestCase;

class InstanceOfTypeTest extends TestCase
{

    public function provideValueTests(): array
    {
        return [
            'instance' => [$this, true],
            'child' => [
                new class extends InstanceOfTypeTest {
                },
                true,
            ],
            'object' => [new \stdClass(), false],
            'string' => ['string', false],
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
        $type = new InstanceOfType(__CLASS__);

        self::assertEquals($test, $type->test($value));
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToString(): void
    {
        $type = new InstanceOfType(__CLASS__);

        self::assertEquals(__CLASS__, $type->toString());
    }
}
