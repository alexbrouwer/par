<?php

declare(strict_types=1);

namespace PARTest\Core\Unit\Values;

use PAR\Core\Hashable;
use PAR\Core\Values;
use PHPUnit\Framework\TestCase;

class EqualsTest extends TestCase
{

    /**
     * @test
     */
    public function itCanDetermineEqualityBetweenHashableAndOther(): void
    {
        $b = 'string';

        $a = $this->createMock(Hashable::class);
        $a->expects(self::once())
            ->method('equals')
            ->with($b)
            ->willReturn(false);

        self::assertFalse(Values::equals($a, $b));
    }

    /**
     * @test
     */
    public function itCanDetermineEqualityBetweenOtherAndHashable(): void
    {
        $b = 'string';

        $a = $this->createMock(Hashable::class);
        $a->expects(self::once())
            ->method('equals')
            ->with($b)
            ->willReturn(false);

        self::assertFalse(Values::equals($b, $a));
    }

    /**
     * @test
     */
    public function itCanDetermineEqualityBetweenNonHashables(): void
    {
        self::assertTrue(Values::equals('foo', 'foo'));

        self::assertFalse(Values::equals('foo', 'bar'));
        self::assertFalse(Values::equals(null, 'bar'));
        self::assertFalse(Values::equals(1, 1.0));
    }
}
