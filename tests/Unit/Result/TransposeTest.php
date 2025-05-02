<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad\Tests\Unit\Result;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use WizDevelop\PhpMonad\Option;
use WizDevelop\PhpMonad\Result;
use WizDevelop\PhpMonad\Tests\TestCase;

#[TestDox('Result - transpose関数のテスト')]
#[CoversClass(Result::class)]
final class TransposeTest extends TestCase
{
    #[Test]
    #[TestDox('Ok(Some(_))をSome(Ok(_))に変換するtransposeのテスト')]
    public function transposeOkSome(): void
    {
        $result = Result\ok(Option\some(42));

        /** @phpstan-ignore-next-line */
        $option = Result\transpose($result);

        $this->assertTrue($option->isSome());
        $this->assertTrue($option->unwrap()->isOk());
        $this->assertSame(42, $option->unwrap()->unwrap());
    }

    #[Test]
    #[TestDox('Ok(None)をNoneに変換するtransposeのテスト')]
    public function transposeOkNone(): void
    {
        $result = Result\ok(Option\none());

        /** @phpstan-ignore-next-line */
        $option = Result\transpose($result);

        $this->assertTrue($option->isNone());
    }

    #[Test]
    #[TestDox('Err(_)をSome(Err(_))に変換するtransposeのテスト')]
    public function transposeErr(): void
    {
        $result = Result\err('error');

        /** @phpstan-ignore-next-line */
        $option = Result\transpose($result);

        $this->assertTrue($option->isSome());
        $this->assertTrue($option->unwrap()->isErr());
        $this->assertSame('error', $option->unwrap()->unwrapErr());
    }
}
