<?php

declare(strict_types=1);

namespace PARTest\Core\Unit\ValueType;

use IteratorAggregate;
use PAR\Core\ValueType\IterableType;
use PHPUnit\Framework\TestCase;

class IterableTypeTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function itCanTestValues(): void
    {
        $type = new IterableType();

        self::assertTrue($type->test([]));
        self::assertTrue(
            $type->test(
                new class implements IteratorAggregate {
                    /**
                     * @inheritDoc
                     */
                    public function getIterator(): iterable
                    {
                        // TODO: Implement getIterator() method.
                    }
                }
            )
        );
        self::assertFalse($type->test(''));
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToString(): void
    {
        $type = new IterableType();

        self::assertEquals('iterable', $type->toString());
    }
}
