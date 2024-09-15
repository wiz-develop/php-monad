<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad\Result;

use EndouMame\PhpMonad\Result;

/**
 * Return a `Result\Ok` Result containing `$value`.
 *
 * @template U
 * @param  U            $value
 * @return Result\Ok<U>
 */
function ok(mixed $value): Result\Ok
{
    return Result\Ok::unit($value);
}

/**
 * Return a `Result\Err` result.
 *
 * @template F
 * @param  F             $value
 * @return Result\Err<F>
 */
function err(mixed $value): Result\Err
{
    return Result\Err::unit($value);
}
