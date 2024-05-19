<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad;

/**
 * Result monad as a Either monad.
 * @template T
 * @template E
 * @extends Monad<T>
 */
interface Result extends Monad
{
    public function isOk(): bool;

    public function isErr(): bool;
}
