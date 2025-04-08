<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad\Tests\Unit;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use WizDevelop\PhpMonad\Option;

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
