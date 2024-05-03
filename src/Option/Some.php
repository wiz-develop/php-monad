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
final class Some extends Option
{
    /**
     * @param T $value
     */
    public function __construct(protected mixed $value)
    {
    }

    /**
     * @param  Closure(T): static<T> $f
     * @return static<T>
     */
    #[Override]
    public function bind(Closure $f): self
    {
        return $f($this->value);
    }
}
