<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad\Tests\Provider;

use DateTimeImmutable;
use EndouMame\PhpMonad\Option;

trait OptionProvider
{
    /**
     * @return iterable<string, array{mixed}>
     */
    public static function values(): iterable
    {
        yield 'null' => [null];
        yield 'empty' => [''];
        yield 'string' => ['example'];
        yield 'int' => [42];
        yield 'float' => [3.14];
        yield 'true' => [true];
        yield 'false' => [false];
        yield 'object' => [(object)[]];
        yield 'array' => [[]];
        yield 'datetime' => [new DateTimeImmutable()];
    }

    /**
     * @return iterable<array{Option<mixed>, mixed, mixed}>
     */
    public static function fromValueMatrix(): iterable
    {
        $o = (object)[];

        yield [Option\none(), null, null];
        yield [Option\some(null), null, 0];

        yield [Option\none(), 0, 0];
        yield [Option\some(0), 0, 1];
        yield [Option\none(), 1, 1];
        yield [Option\some(1), 1, 0];
        yield [Option\some(1), 1, ''];
        yield [Option\some(1), 1, '1'];
        yield [Option\some(1), 1, true];

        yield [Option\none(), [], []];
        yield [Option\some([1]), [1], [2]];

        yield [Option\none(), $o, $o];
        yield [Option\some($o), $o, (object)[]];
    }
}
