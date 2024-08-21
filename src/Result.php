<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad;

use Closure;
use RuntimeException;
use Throwable;

/**
 * Result monad as a `Either monad`.
 * @template T
 * @template E
 * @extends Monad<T>
 */
interface Result extends Monad
{
    public function isOk(): bool;

    public function isErr(): bool;

    /**
     * @param Closure(T) :bool $predicate
     */
    public function isOkAnd(Closure $predicate): bool;

    /**
     * @param Closure(E) :bool $predicate
     */
    public function isErrAnd(Closure $predicate): bool;

    /**
     * @return T
     * @throws RuntimeException
     */
    public function expect(string $message): mixed;

    /**
     * @return T
     * @throws Throwable
     */
    public function unwrap(): mixed;

    /**
     * @return E
     * @throws RuntimeException
     */
    public function unwrapErr(): mixed;

    /**
     * @template U
     * @param  U   $default
     * @return T|U
     */
    public function unwrapOr(mixed $default): mixed;

    /**
     * @template U
     * @param  Closure(E) :U $default
     * @return T|U
     */
    public function unwrapOrElse(Closure $default): mixed;

    /**
     * @param  Closure(T) :mixed $callback
     * @return $this
     */
    public function inspect(Closure $callback): self;

    /**
     * @param  Closure(E) :mixed $callback
     * @return $this
     */
    public function inspectErr(Closure $callback): self;

    /**
     * @template U
     * @param  Result<U, E> $right
     * @return Result<U, E>
     */
    public function and(self $right): self;

    /**
     * @template U
     * @template F
     * @param  Closure(T) :Result<U, F> $right
     * @return Result<U, E|F>
     */
    public function andThen(Closure $right): self;

    /**
     * @template F
     * @param  Result<T, F> $right
     * @return Result<T, F>
     */
    public function or(self $right): self;

    /**
     * @template F
     * @param  Closure(E) :Result<T, F> $right
     * @return Result<T, F>
     */
    public function orElse(Closure $right): self;

    /**
     * @template U
     * @param  Closure(T) :U $callback
     * @return Result<U, E>
     */
    public function map(Closure $callback): self;

    /**
     * @template F
     * @param  Closure(E) :F $callback
     * @return Result<T, F>
     */
    public function mapErr(Closure $callback): self;

    /**
     * @template U
     * @param  Closure(T):U $callback
     * @param  U            $default
     * @return U
     */
    public function mapOr(Closure $callback, mixed $default): mixed;

    /**
     * @template U
     * @param  Closure(T):U $callback
     * @param  Closure(E):U $default
     * @return U
     */
    public function mapOrElse(Closure $callback, Closure $default): mixed;

    /**
     * @return Option<T>
     */
    public function ok(): Option;

    /**
     * @return Option<E>
     */
    public function err(): Option;
}
