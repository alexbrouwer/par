<?php

declare( strict_types=1 );

namespace PARTest\Core\PHPUnit\Constraint;

use PAR\Core\Hashable;
use PAR\Core\PHPUnit\Constraint\HashableEquals;
use PARTest\Core\Fixtures\GenericHashable;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

final class HashableEqualsTest extends TestCase {

    public function provideDataForEvaluate (): array {
        $expectedHash = 'hash';
        $expected = new GenericHashable( $expectedHash );
        $other = new GenericHashable( 'other' );

        return [
            'same-hashable' => [ $expected, $expected, true ],
            'other-hashable' => [ $expected, $other, false ],
            'other-value' => [ $expected, '', false ],
        ];
    }

    /**
     * @test
     * @dataProvider provideDataForEvaluate
     *
     * @param Hashable $object
     * @param mixed    $other
     * @param bool     $expectedResult
     */
    public function itCanEvaluateOther ( Hashable $object, $other, bool $expectedResult ): void {

        $constraint = new HashableEquals( $object );
        $this->assertSame( $expectedResult, $constraint->evaluate( $other, '', true ) );
    }

    /**
     * @test
     */
    public function itCanCreateDescriptionForFailure (): void {
        $expected = new GenericHashable( 'foo' );
        $constraint = new HashableEquals( $expected );

        $this->expectException( ExpectationFailedException::class );
        $this->expectExceptionMessage(
            'Failed asserting that PARTest\Core\Fixtures\GenericHashable@bar equals PARTest\Core\Fixtures\GenericHashable@foo.
--- Expected
+++ Actual
@@ @@
-PARTest\Core\Fixtures\GenericHashable@foo
+PARTest\Core\Fixtures\GenericHashable@bar'
        );
        $constraint->evaluate( new GenericHashable( 'bar' ) );
    }

}
