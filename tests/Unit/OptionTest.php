<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad\Tests\Unit;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use WizDevelop\PhpMonad\Monad;
use WizDevelop\PhpMonad\Option;

/**
 * @extends MonadTestAbstract<Option>
 */
#[TestDox('Option - MonadTest')]
#[CoversClass(Option::class)]
final class OptionTest extends MonadTestAbstract
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

    /**
     * @param Monad<string> $subject
     */
    #[Test]
    #[TestDox('Monad laws')]
    #[DataProvider('monadsProvider')]
    public function monadLaws(Monad $subject): void
    {
        parent::monadLaws($subject);
    }
}
