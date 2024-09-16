<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad\Option;

use EndouMame\PhpMonad\Option;

/**
 * Return a `Option\Some` option containing `$value`.
 *
 * @template T
 * @param  T              $value
 * @return Option\Some<T>
 */
function some(mixed $value): Option\Some
{
    return Option\Some::unit($value);
}

/**
 * Return a `Option\None` option containing no values.
 */
function none(): Option\None
{
    return Option\None::unit(null);
}

/**
 * Transform a value into an `Option`.
 * It will be a `Some` option containing `$value` if `$value` is different from `$noneValue` (default `null`)
 *
 * @template U
 * @param  U         $value
 * @return Option<U>
 */
function fromValue(mixed $value, mixed $noneValue = null): Option
{
    return $value === $noneValue
        ? Option\none()
        : Option\some($value);
}
