<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad\Option;

use Exception;
use Throwable;
use WizDevelop\PhpMonad\Option;
use WizDevelop\PhpMonad\Result;

use function is_a;

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
 * @param  U|null    $value
 * @return Option<U>
 */
function fromValue($value, mixed $noneValue = null, bool $strict = true): Option
{
    $same = $strict
        ? ($value === $noneValue)
        : ($value == $noneValue);

    return $same
        ? Option\none()
        : Option\some($value);
}

/**
 * Execute a callable and transform the result into an `Option`.
 * It will be a `Some` option containing the result if it is different from `$noneValue` (default `null`).
 *
 * @template U
 * @param  callable():U|null $callback
 * @return Option<U>
 */
function of(callable $callback, mixed $noneValue = null, bool $strict = true): Option
{
    return Option\fromValue($callback(), $noneValue, $strict);
}

/**
 * Execute a callable and transform the result into an `Option` as `Option\of()` does
 * but also return `Option\None` if it an exception matching $exceptionClass was thrown.
 *
 * @template U
 * @template E of \Throwable
 * @param  callable():U|null    $callback
 * @param  class-string<E> $exceptionClass
 * @return Option<U>
 * @throws Throwable
 */
function tryOf(
    callable $callback,
    mixed $noneValue = null,
    bool $strict = true,
    string $exceptionClass = Exception::class,
): Option {
    try {
        return Option\of($callback, $noneValue, $strict);
    } catch (Throwable $th) {
        if (is_a($th, $exceptionClass)) {
            return Option\none();
        }

        throw $th;
    }
}

/**
 * Converts from `Option<Option<T>>` to `Option<T>`.
 *
 * @template U
 * @param  Option<Option<U>> $option
 * @return Option<U>
 */
function flatten(Option $option): Option
{
    return $option instanceof Option\None
        ? $option
        : $option->unwrap();
}

/**
 * Transposes an `Option` of a `Result` into a `Result` of an `Option`.
 *
 * `None` will be mapped to `Ok(None)`.
 * `Some(Ok(_))` and `Some(Err(_))` will be mapped to `Ok(Some(_))` and `Err(_)`.
 *
 * @template U
 * @template E
 * @param  Option<Result<U, E>> $option
 * @return Result<Option<U>, E>
 */
function transpose(Option $option): Result
{
    // @phpstan-ignore-next-line
    return $option->mapOrElse(
        static fn (Result $result) => $result->map(Option\some(...)),
        static fn () => Result\ok(Option\none()),
    );
}
