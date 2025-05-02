<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad\Tests\Unit\Result;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use WizDevelop\PhpMonad\Result;
use WizDevelop\PhpMonad\Tests\TestCase;

#[TestDox('Result - combine関数のテスト')]
#[CoversClass(Result::class)]
final class CombineTest extends TestCase
{
    #[Test]
    #[TestDox('すべてがOkの場合はOk(true)を返すcombineのテスト')]
    public function combineAllOk(): void
    {
        $results = [
            Result\ok(1),
            Result\ok('test'),
            Result\ok(true),
        ];

        $result = Result\combine(...$results);

        $this->assertTrue($result->isOk());
        $this->assertTrue($result->unwrap());
    }

    #[Test]
    #[TestDox('1つでもErrがある場合はErr(list<E>)を返すcombineのテスト')]
    public function combineWithErrors(): void
    {
        $results = [
            Result\ok(1),
            Result\err('error1'),
            Result\ok(true),
            Result\err('error2'),
            Result\ok('test'),
        ];

        $result = Result\combine(...$results);

        $this->assertTrue($result->isErr());
        $errors = $result->unwrapErr();
        $this->assertIsArray($errors);
        $this->assertCount(2, $errors);
        // エラーの順序は配列のフィルタリング方法によって決まる
        // 2つのエラーが含まれていることを確認
        $this->assertTrue($errors[0] === 'error1');
        $this->assertTrue($errors[1] === 'error2');
        // $this->assertTrue(in_array('error1', $errors, true));
        // $this->assertTrue(in_array('error2', $errors, true));
    }

    #[Test]
    #[TestDox('空の配列を渡した場合はOk(true)を返すcombineのテスト')]
    public function combineEmpty(): void
    {
        $result = Result\combine();

        $this->assertTrue($result->isOk());
        $this->assertTrue($result->unwrap());
    }
}
