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
