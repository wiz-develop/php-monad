<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

/**
 * @template TMonad of Monad
 */
#[TestDox('Monad test')]
abstract class MonadTest extends TestCase
{
    /**
     * @return iterable<array{TMonad<string>}>
     */
    abstract public function monadsProvider(): iterable;

    /**
     * Test Monad laws
     *
     * @see https://wiki.haskell.org/Monad_laws
     */
    #[Test]
    #[TestDox('Monad laws')]
    public function monadLaws(): void
    {
    }
}
