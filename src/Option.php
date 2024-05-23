<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad;

use Closure;
use RuntimeException;

/**
 * Option monad as a `Maybe monad`.
 * @template T
 * @extends Monad<T>
 */
interface Option extends Monad
{
    public function isSome(): bool;

    public function isNone(): bool;

    /**
     * @param Closure(T): bool $predicate
     */
    public function isSomeAnd(Closure $predicate): bool;

    /**
     * @return T
     * @throws RuntimeException
     */
    public function expect(string $message): mixed;

    /**
     * @return T
     * @throws RuntimeException
     */
    public function unwrap(): mixed;

    /**
     * @template U
     * @param  U   $default
     * @return T|U
     */
    public function unwrapOr(mixed $default): mixed;

    /**
     * @template U
     * @param  Closure(): U $default
     * @return T|U
     */
    public function unwrapOrElse(Closure $default): mixed;

    /**
     * @param  Closure(T): mixed $callback
     * @return $this
     */
    public function inspect(Closure $callback): self;

    /**
     * @template U
     * @param  Option<U> $right
     * @return Option<U>
     */
    public function and(self $right): self;

    /**
     * NOTE: PHPdoc's completion by type specification in Closure doesn't work, so I'm redefining it.
     * @template U
     * @param  Closure(T): Option<U> $right
     * @return Option<U>
     */
    public function andThen(Closure $right): self;

    /**
     * @param  Option<T> $right
     * @return Option<T>
     */
    public function or(self $right): self;

    /**
     * @template U
     * @param  Closure(): Option<U> $right
     * @return Option<T|U>
     */
    public function orElse(Closure $right): self;

    /**
     * @param  Option<T> $right
     * @return Option<T>
     */
    public function xor(self $right): self;

    /**
     * @param  Closure(T): bool $predicate
     * @return Option<T>
     */
    public function filter(Closure $predicate): self;

    /**
     * @template U
     * @param  Closure(T): U $callback
     * @return Option<U>
     */
    public function map(Closure $callback): self;

    /**
     * @template U
     * @param  Closure(T) :U $callback
     * @param  U             $default
     * @return U
     */
    public function mapOr(Closure $callback, mixed $default): mixed;

    /**
     * @template U
     * @param  Closure(T): U $callback
     * @param  Closure(): U  $default
     * @return U
     */
    public function mapOrElse(Closure $callback, Closure $default): mixed;

    /**
     * @template E
     * @param  E            $err
     * @return Result<T, E>
     */
    public function okOr(mixed $err): Result;

    /**
     * @template E
     * @param  Closure() :E $err
     * @return Result<T, E>
     */
    public function okOrElse(Closure $err): Result;
}
