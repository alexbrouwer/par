<?php

declare(strict_types=1);

namespace PAR\DocTest;

/**
 * Class summary
 *
 * Class description containing `markdown`.
 *
 * @package Test
 */
abstract class ComplexClass extends AbstractClass implements OtherInterface, \JsonSerializable
{
    use FooTrait;

    public const TYPE_FOO = 'foo';
    public const TYPE_BAR = 'bar';

    protected const PROTECTED_BAR = 'bar';

    private const PRIVATE_FOO = 'foo';
    public static string $baz = '';
    public ?string $foo = null;
    public ?AbstractClass $bar;

    /**
     * Summary
     *
     * @param int                        $arg1
     * @param AbstractClass|ComplexClass $arg2
     * @param int                        ...$arg3
     *
     * @return AbstractClass|ComplexClass
     */
    abstract protected static function foo(int $arg1, AbstractClass $arg2, int ...$arg3): AbstractClass;

    public function jsonSerialize(): array
    {
        // TODO: Implement jsonSerialize() method.
    }

    public function bar(bool $arg1 = false): void
    {
    }


}
