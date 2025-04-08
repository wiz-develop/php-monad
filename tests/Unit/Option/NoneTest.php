<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad\Tests\Unit\Option;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use WizDevelop\PhpMonad\Option;
use WizDevelop\PhpMonad\Tests\Assert;
use WizDevelop\PhpMonad\Tests\TestCase;

#[TestDox('Option - NoneTest')]
#[CoversClass(Option::class)]
final class NoneTest extends TestCase
{
    #[Test]
    #[TestDox('noneIsASingleton test')]
    public function noneIsASingleton(): void
    {
        Assert::assertEquals(Option\none(), Option\none());

        Assert::assertSame(Option\none(), Option\none());
    }
}
