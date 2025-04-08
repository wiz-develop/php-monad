<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad\Tests\Unit\Option;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use RuntimeException;
use WizDevelop\PhpMonad\Option;
use WizDevelop\PhpMonad\Tests\Assert;
use WizDevelop\PhpMonad\Tests\Provider\ValueProvider;
use WizDevelop\PhpMonad\Tests\TestCase;

#[TestDox('Option - ExpectTest')]
#[CoversClass(Option::class)]
final class ExpectTest extends TestCase
{
    use ValueProvider;

    #[Test]
    #[TestDox('expectNone test')]
    public function expectNone(): void
    {
        $this->expectExceptionObject(new RuntimeException('This should fail'));

        Option\none()->expect('This should fail');
    }

    #[Test]
    #[TestDox('expectSome test')]
    #[DataProvider('values')]
    public function expectSome(mixed $value): void
    {
        Assert::assertSame($value, Option\some($value)->expect('This should succeed'));
    }
}
