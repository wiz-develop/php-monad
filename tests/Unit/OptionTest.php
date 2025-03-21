<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad\Tests\Unit;

use EndouMame\PhpMonad\Option;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

/**
 * @extends MonadTest<Option>
 */
#[TestDox('Option - MonadTest')]
#[CoversClass(Option::class)]
final class OptionTest extends MonadTest
{
    /**
     * @return iterable<array{Option<string>}>
     */
    #[Override]
    public static function monadsProvider(): iterable
    {
        yield 'just' => [Option\some('Monad')];
        yield 'nothing' => [Option\none()];
    }
}
