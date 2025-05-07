<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad\Tests\Unit\Result;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use WizDevelop\PhpMonad\Result;
use WizDevelop\PhpMonad\Tests\Assert;
use WizDevelop\PhpMonad\Tests\TestCase;
use WizDevelop\PhpValueObject\Error\ErrorValue;

#[TestDox('Result - combineWithErrorValue関数のテスト')]
#[CoversClass(Result::class)]
final class CombineWithErrorValueTest extends TestCase
{
    #[Test]
    #[TestDox('すべてがOkの場合はOk(true)を返すcombineWithErrorValueのテスト')]
    public function combineWithErrorValueAllOk(): void
    {
        $results = [
            Result\ok(1),
            Result\ok('test'),
            Result\ok(true),
        ];

        $result = Result\combineWithErrorValue(...$results);

        Assert::assertTrue($result->isOk());
        Assert::assertTrue($result->unwrap());
    }

    #[Test]
    #[TestDox('1つでもErrがある場合はErr(list<E>)を返すcombineWithErrorValueのテスト')]
    public function combineWithErrorValueWithErrors(): void
    {
        $error1 = ErrorValue::of('error1', 'Error message 1');
        $error2 = ErrorValue::of('error2', 'Error message 2');

        $results = [
            Result\ok(1),
            Result\err($error1),
            Result\ok(true),
            Result\err($error2),
            Result\ok('test'),
        ];

        $result = Result\combineWithErrorValue(...$results);

        Assert::assertTrue($result->isErr());
        $errors = $result->unwrapErr();
        Assert::assertIsArray($errors);
        Assert::assertCount(2, $errors);

        // エラーの順序は配列のフィルタリング方法によって決まる
        // 2つのエラーが含まれていることを確認
        Assert::assertSame($error1, $errors[0]);
        Assert::assertSame($error2, $errors[1]);

        // エラーコードとメッセージが正しいことを確認
        Assert::assertSame('error1', $errors[0]->getCode());
        Assert::assertSame('Error message 1', $errors[0]->getMessage());
        Assert::assertSame('error2', $errors[1]->getCode());
        Assert::assertSame('Error message 2', $errors[1]->getMessage());
    }

    #[Test]
    #[TestDox('空の配列を渡した場合はOk(true)を返すcombineWithErrorValueのテスト')]
    public function combineWithErrorValueEmpty(): void
    {
        $result = Result\combineWithErrorValue();

        Assert::assertTrue($result->isOk());
        Assert::assertTrue($result->unwrap());
    }
}
