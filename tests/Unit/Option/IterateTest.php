<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad\Tests\Unit\Option;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use WizDevelop\PhpMonad\Option;
use WizDevelop\PhpMonad\Tests\Assert;
use WizDevelop\PhpMonad\Tests\TestCase;

use function iterator_to_array;

#[TestDox('Option - IterateTest')]
#[CoversClass(Option::class)]
final class IterateTest extends TestCase
{
    #[Test]
    #[TestDox('iterateOptions test')]
    public function iterateOptions(): void
    {
        Assert::assertSame([], iterator_to_array(Option\none()));

        Assert::assertSame([42], iterator_to_array(Option\some(42)));
    }
}
