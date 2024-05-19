<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad;

use Closure;

/**
 * @template T
 * @immutable
 */
interface Monad
{
    /**
     * `return` in Haskell.
     * @template TValue
     * @param  TValue         $value
     * @return static<TValue>
     */
    public static function unit(mixed $value): self;

    /**
     * `>>=` in Haskell.
     * @template U
     * @param  Closure(T): static<U> $right
     * @return static<U>
     */
    public function andThen(Closure $right): self;
}
