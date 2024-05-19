<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad\Option;

use Closure;
use EndouMame\PhpMonad\Option;
use Override;

/**
 * @template T
 * @implements Option<T>
 */
final readonly class Some implements Option
{
    /**
     * @param T $value
     */
    private function __construct(private mixed $value)
    {
    }

    /**
     * @template TValue
     * @param  TValue       $value
     * @return self<TValue>
     */
    #[Override]
    public static function unit(mixed $value): self
    {
        return new self($value);
    }

    /**
     * @template U
     * @param  Closure(T): self<U> $right
     * @return self<U>
     */
    #[Override]
    public function andThen(Closure $right): self
    {
        return $right($this->value);
    }

    #[Override]
    public function isSome(): true
    {
        return true;
    }

    #[Override]
    public function isNone(): false
    {
        return false;
    }

    #[Override]
    public function isSomeAnd(Closure $predicate): bool
    {
        return $predicate($this->value);
    }

    /**
     * @throws void
     */
    #[Override]
    public function expect(string $message): mixed
    {
        return $this->value;
    }

    /**
     * @throws void
     */
    #[Override]
    public function unwrap(): mixed
    {
        return $this->value;
    }

    /**
     * @return T
     */
    #[Override]
    public function unwrapOr(mixed $default): mixed
    {
        return $this->value;
    }

    /**
     * @return T
     */
    #[Override]
    public function unwrapOrElse(Closure $default): mixed
    {
        return $this->value;
    }

    #[Override]
    public function inspect(Closure $callback): self
    {
        $callback($this->value);

        return $this;
    }

    #[Override]
    public function and(Option $right): Option
    {
        return $right;
    }

    /**
     * @return $this
     */
    #[Override]
    public function or(Option $right): Option
    {
        return $this;
    }

    /**
     * @return $this
     */
    #[Override]
    public function orElse(Closure $right): Option
    {
        return $this;
    }

    #[Override]
    public function xor(Option $right): Option
    {
        return $right instanceof Option\None
            ? $this
            : Option\none();
    }
}
