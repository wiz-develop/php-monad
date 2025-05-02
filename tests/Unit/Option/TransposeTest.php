<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad\Tests\Unit\Option;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use WizDevelop\PhpMonad\Option;
use WizDevelop\PhpMonad\Result;
use WizDevelop\PhpMonad\Tests\TestCase;

#[TestDox('Option - transpose関数のテスト')]
#[CoversClass(Option::class)]
final class TransposeTest extends TestCase
{
    #[Test]
    #[TestDox('Some(Ok(_))をOk(Some(_))に変換するtransposeのテスト')]
    public function transposeSomeOk(): void
    {
        $option = Option\some(Result\ok(42));

        /** @phpstan-ignore-next-line */
        $result = Option\transpose($option);

        $this->assertTrue($result->isOk());
        $this->assertTrue($result->unwrap()->isSome());
        $this->assertSame(42, $result->unwrap()->unwrap());
    }

    #[Test]
    #[TestDox('Some(Err(_))をErr(_)に変換するtransposeのテスト')]
    public function transposeSomeErr(): void
    {
        $option = Option\some(Result\err('error'));

        /** @phpstan-ignore-next-line */
        $result = Option\transpose($option);

        $this->assertTrue($result->isErr());
        $this->assertSame('error', $result->unwrapErr());
    }

    #[Test]
    #[TestDox('NoneをOk(None)に変換するtransposeのテスト')]
    public function transposeNone(): void
    {
        $option = Option\none();

        /** @phpstan-ignore-next-line */
        $result = Option\transpose($option);

        $this->assertTrue($result->isOk());
        $this->assertTrue($result->unwrap()->isNone());
    }
}
