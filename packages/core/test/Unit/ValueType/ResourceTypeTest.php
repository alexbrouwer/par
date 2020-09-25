<?php

declare(strict_types=1);

namespace PARTest\Core\Unit\ValueType;

use PAR\Core\ValueType\ResourceType;
use PARTest\Core\Traits\ResourceTrait;
use PHPUnit\Framework\TestCase;

class ResourceTypeTest extends TestCase
{
    use ResourceTrait;


    /**
     * @test
     * @return void
     */
    public function itCanTestValues(): void
    {
        $type = new ResourceType();

        self::assertTrue($type->test($this->createResource()));
        self::assertTrue($type->test($this->createClosedResource()));

        self::assertFalse($type->test(''));
    }

    /**
     * @test
     * @return void
     */
    public function itCanBeTransformedToString(): void
    {
        $type = new ResourceType();

        self::assertEquals('resource', $type->toString());
    }
}
