<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad;

use EndouMame\PhpMonad\Option\Some;

/**
 * @template T
 * @implements Monad<T>
 */
abstract class Option implements Monad
{
    /**
     * @template TValue
     * @param  TValue         $value
     * @return Option<TValue>
     */
    public static function unit(mixed $value): self
    {
        return new Some($value);
    }
}
