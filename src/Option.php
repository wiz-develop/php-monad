<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad;

use Closure;
use RuntimeException;

/**
 * Option monad as a `Maybe monad`.
 * Inspired by Rust's `Option` enum.
 * @see https://doc.rust-lang.org/std/option/enum.Option.html
 * @template T
 * @extends Monad<T>
 */
interface Option extends Monad
{
    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.is_some
     */
    public function isSome(): bool;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.is_none
     */
    public function isNone(): bool;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.is_some_and
     * @param Closure(T): bool $predicate
     */
    public function isSomeAnd(Closure $predicate): bool;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.expect
     * @return T
     * @throws RuntimeException
     */
    public function expect(string $message): mixed;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.unwrap
     * @return T
     * @throws RuntimeException
     */
    public function unwrap(): mixed;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.unwrap_or
     * @template U
     * @param  U   $default
     * @return T|U
     */
    public function unwrapOr(mixed $default): mixed;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.unwrap_or_else
     * @template U
     * @param  Closure(): U $default
     * @return T|U
     */
    public function unwrapOrElse(Closure $default): mixed;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.inspect
     * @param  Closure(T): mixed $callback
     * @return $this
     */
    public function inspect(Closure $callback): self;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.and
     * @template U
     * @param  Option<U> $right
     * @return Option<U>
     */
    public function and(self $right): self;

    /**
     * NOTE: PHPdoc's completion by type specification in Closure doesn't work, so I'm redefining it.
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.and_then
     * @template U
     * @param  Closure(T): Option<U> $right
     * @return Option<U>
     */
    public function andThen(Closure $right): self;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.or
     * @param  Option<T> $right
     * @return Option<T>
     */
    public function or(self $right): self;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.or_else
     * @template U
     * @param  Closure(): Option<U> $right
     * @return Option<T|U>
     */
    public function orElse(Closure $right): self;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.xor
     * @param  Option<T> $right
     * @return Option<T>
     */
    public function xor(self $right): self;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.filter
     * @param  Closure(T): bool $predicate
     * @return Option<T>
     */
    public function filter(Closure $predicate): self;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.map
     * @template U
     * @param  Closure(T): U $callback
     * @return Option<U>
     */
    public function map(Closure $callback): self;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.map_or
     * @template U
     * @param  Closure(T) :U $callback
     * @param  U             $default
     * @return U
     */
    public function mapOr(Closure $callback, mixed $default): mixed;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.map_or_else
     * @template U
     * @param  Closure(T): U $callback
     * @param  Closure(): U  $default
     * @return U
     */
    public function mapOrElse(Closure $callback, Closure $default): mixed;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.ok_or
     * @template E
     * @param  E            $err
     * @return Result<T, E>
     */
    public function okOr(mixed $err): Result;

    /**
     * @see https://doc.rust-lang.org/std/option/enum.Option.html#method.ok_or_else
     * @template E
     * @param  Closure() :E $err
     * @return Result<T, E>
     */
    public function okOrElse(Closure $err): Result;
}
