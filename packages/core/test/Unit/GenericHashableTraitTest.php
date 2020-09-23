<?php

declare(strict_types=1);

namespace PARTest\Core\Unit;

use PARTest\Core\Fixtures\GenericHashable;
use PHPUnit\Framework\TestCase;
use stdClass;

class GenericHashableTraitTest extends TestCase
{

    /**
     * @test
     */
    public function itIsEqualToSelf(): void
    {
        $instance = new GenericHashable('hash');

        self::assertTrue($instance->equals($instance));
    }

    /**
     * @test
     */
    public function itIsEqualToInstanceWithSameHash(): void
    {
        $instance = new GenericHashable('hash');
        $other = new GenericHashable('hash');

        self::assertNotSame($other, $instance);
        self::assertTrue($instance->equals($other));
    }

    /**
     * @test
     */
    public function itIsNotEqualToInstanceWithDifferentHash(): void
    {
        $instance = new GenericHashable('hash');
        $other = new GenericHashable('other-hash');

        self::assertFalse($instance->equals($other));
    }

    /**
     * @test
     */
    public function itIsNotEqualToInstanceOfDifferentType(): void
    {
        $instance = new GenericHashable('hash');
        $other = new stdClass();

        self::assertFalse($instance->equals($other));
    }

    /**
     * @test
     */
    public function itIsNotEqualToDifferentValueType(): void
    {
        $instance = new GenericHashable(null);
        $other = null;

        self::assertFalse($instance->equals($other));
    }

    /**
     * @test
     */
    public function itIsNotEqualToInstanceOfChildWithSameHash(): void
    {
        $hash = 'foo';
        $instance = new GenericHashable($hash);
        $other = new class ($hash) extends GenericHashable {

        };

        self::assertFalse($instance->equals($other));
    }

    /**
     * @test
     */
    public function itIsNotEqualToInstanceOfParentWithSameHash(): void
    {
        $hash = 'hash';
        $instance = new class ($hash) extends GenericHashable {

        };
        $other = new GenericHashable($hash);

        self::assertFalse($instance->equals($other));
    }

    /**
     * @test
     */
    public function itCanBeTransformedToString(): void
    {
        $hash = 'hash';
        $instance = new GenericHashable($hash);

        self::assertSame(
            sprintf('%s@%s', get_class($instance), $hash),
            (string)$instance
        );
    }
}
