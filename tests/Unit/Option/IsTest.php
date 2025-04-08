<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad\Tests\Unit\Option;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use WizDevelop\PhpMonad\Option;
use WizDevelop\PhpMonad\Tests\Assert;
use WizDevelop\PhpMonad\Tests\Provider\ValueProvider;
use WizDevelop\PhpMonad\Tests\TestCase;

#[TestDox('Option - IsTest')]
#[CoversClass(Option::class)]
final class IsTest extends TestCase
{
    use ValueProvider;

    #[Test]
    #[TestDox('isSome test')]
    #[DataProvider('values')]
    public function isSome(mixed $value): void
    {
        /** @var Option<mixed> $option */
        $option = Option\some($value);

        Assert::assertTrue($option->isSome());

        /** @var Option<never> $option */
        $option = Option\none();

        Assert::assertFalse($option->isSome());
    }

    #[Test]
    #[TestDox('isNone test')]
    #[DataProvider('values')]
    public function isNone(mixed $value): void
    {
        /** @var Option<mixed> $option */
        $option = Option\some($value);

        Assert::assertFalse($option->isNone());

        /** @var Option<never> $option */
        $option = Option\none();

        Assert::assertTrue($option->isNone());
    }

    #[Test]
    #[TestDox('isSomeAnd test')]
    #[DataProvider('values')]
    public function isSomeAnd(mixed $value): void
    {
        /** @var Option<mixed> $option */
        $option = Option\some($value);

        Assert::assertTrue($option->isSomeAnd(static fn (mixed $v) => $v === $value));
        Assert::assertFalse($option->isSomeAnd(static fn (mixed $v) => $v !== $value));

        /** @var Option<never> $option */
        $option = Option\none();

        Assert::assertFalse($option->isSomeAnd(static fn (mixed $v) => Assert::fail('predicate should be called')));
        Assert::assertFalse($option->isSomeAnd(static fn (mixed $v) => Assert::fail('predicate should be called')));
    }
}
