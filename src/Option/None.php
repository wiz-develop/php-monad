<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad\Option;

use Closure;
use EmptyIterator;
use EndouMame\PhpMonad\Option;
use EndouMame\PhpMonad\Result;
use Override;
use RuntimeException;
use Traversable;

/**
 * @implements Option<never>
 */
enum None implements Option
{
    case instance;

    /**
     * @internal
     * @return self<never>
     */
    #[Override]
    public static function unit(mixed $value): self
    {
        return self::instance;
    }

    /**
     * @return $this
     */
    #[Override]
    public function andThen(Closure $right): self
    {
        return $this;
    }

    #[Override]
    public function isSome(): false
    {
        return false;
    }

    #[Override]
    public function isNone(): true
    {
        return true;
    }

    #[Override]
    public function isSomeAnd(Closure $predicate): false
    {
        return false;
    }

    /**
     * @throws RuntimeException
     */
    #[Override]
    public function expect(string $message): never
    {
        throw new RuntimeException($message);
    }

    /**
     * @throws RuntimeException
     */
    #[Override]
    public function unwrap(): never
    {
        $this->expect('Unwrapping a `None` value');
    }

    #[Override]
    public function unwrapOr(mixed $default): mixed
    {
        return $default;
    }

    #[Override]
    public function unwrapOrElse(Closure $default): mixed
    {
        return $default();
    }

    /**
     * @return $this
     */
    #[Override]
    public function inspect(Closure $callback): self
    {
        return $this;
    }

    /**
     * @return $this
     */
    #[Override]
    public function and(Option $right): Option
    {
        return $this;
    }

    #[Override]
    public function or(Option $right): Option
    {
        return $right;
    }

    #[Override]
    public function orElse(Closure $right): Option
    {
        return $right();
    }

    #[Override]
    public function xor(Option $right): Option
    {
        return $right;
    }

    #[Override]
    public function filter(Closure $predicate): Option
    {
        return $this;
    }

    #[Override]
    public function map(Closure $callback): Option
    {
        return $this;
    }

    #[Override]
    public function mapOr(Closure $callback, mixed $default): mixed
    {
        return $default;
    }

    #[Override]
    public function mapOrElse(Closure $callback, Closure $default): mixed
    {
        return $default();
    }

    /**
     * @template E
     * @param  E             $err
     * @return Result\Err<E>
     */
    #[Override]
    public function okOr(mixed $err): Result\Err
    {
        return Result\err($err);
    }

    /**
     * @template E
     * @param  Closure() :E  $err
     * @return Result\Err<E>
     */
    #[Override]
    public function okOrElse(Closure $err): Result\Err
    {
        return Result\err($err());
    }

    #[Override]
    public function getIterator(): Traversable
    {
        return new EmptyIterator();
    }
}
