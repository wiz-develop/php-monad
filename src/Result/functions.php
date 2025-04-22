<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad\Result;

use Throwable;
use WizDevelop\PhpMonad\Result;

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

/**
 * Converts from `Result<Result<T, E>, E>` to `Result<T, E>`.
 *
 * @template T
 * @template E
 * @template E1 of E
 * @template E2 of E
 * @param  Result<Result<T, E1>, E2> $result
 * @return Result<T, E>
 */
function flatten(Result $result): Result
{
    // @phpstan-ignore return.type
    return $result->mapOrElse(
        static fn (Result $r) => $r,
        static fn (mixed $err) => Result\err($err),
    );
}

/**
 * Creates a Result from a callable that may throw an exception.
 *
 * @template T
 * @template E
 * @param  callable(): T          $callback
 * @param  callable(Throwable): E $errorHandler
 * @return Result<T, E>
 */
function fromThrowable(callable $callback, callable $errorHandler): Result
{
    try {
        return ok($callback());
    } catch (Throwable $e) {
        return err($errorHandler($e));
    }
}
