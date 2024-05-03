<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad\Option;

use Closure;
use EndouMame\PhpMonad\Option;
use Override;

/**
 * @template T
 * @extends Option<T>
 */
final class None extends Option
{
    /**
     * @param T $value
     */
    public function __construct(protected mixed $value)
    {
    }

    /**
     * @template T2
     * @param  Closure(T): static<T2> $f
     * @return static<T2>
     */
    #[Override]
    public function bind(Closure $f): self
    {
        /** @var T2 */
        $v = null;

        return self::unit($v);
    }

    /**
     * @template TValue
     * @param  TValue       $value
     * @return None<TValue>
     */
    #[Override]
    public static function unit(mixed $value): self
    {
        return new self($value);
    }
}
