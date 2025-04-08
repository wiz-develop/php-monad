<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad\Tests\Unit\Option;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use WizDevelop\PhpMonad\Option;
use WizDevelop\PhpMonad\Tests\Assert;
use WizDevelop\PhpMonad\Tests\Provider\OptionProvider;
use WizDevelop\PhpMonad\Tests\TestCase;

#[TestDox('Option - FromValueTest')]
#[CoversClass(Option::class)]
final class FromValueTest extends TestCase
{
    use OptionProvider;

    /**
     * @param Option<mixed> $expected
     */
    #[Test]
    #[TestDox('fromValue test')]
    #[DataProvider('fromValueMatrix')]
    public function fromValue(Option $expected, mixed $value, mixed $noneValue): void
    {
        Assert::assertEquals($expected, Option\fromValue($value, $noneValue));
    }

    #[Test]
    #[TestDox('fromValueDefaultToNull test')]
    public function fromValueDefaultToNull(): void
    {
        Assert::assertEquals(Option\none(), Option\fromValue(null));
        Assert::assertEquals(Option\some(1), Option\fromValue(1));
    }
}
