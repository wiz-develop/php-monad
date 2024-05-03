<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad;

use Closure;

/**
 * @template T
 */
interface Monad
{
    /**
     * @template T2
     * @param  Closure(T):static<T2> $f
     * @return static<T2>
     */
    public function bind(Closure $f): self;

    /**
     * @template TValue
     * @param  TValue         $value
     * @return static<TValue>
     */
    public static function unit(mixed $value): self;
}
