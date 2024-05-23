<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad;

use Closure;
use IteratorAggregate;

/**
 * @template T
 * @extends IteratorAggregate<T>
 * @immutable
 */
interface Monad extends IteratorAggregate
{
    /**
     * `return` in Haskell.
     * @template TValue
     * @param  TValue        $value
     * @return Monad<TValue>
     */
    public static function unit(mixed $value): self;

    /**
     * `>>=` in Haskell.
     * @template U
     * @param  Closure(T): Monad<U> $right
     * @return Monad<U>
     */
    public function andThen(Closure $right): self;
}
