<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad\Tests\Unit\Option;

use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use WizDevelop\PhpMonad\Option;
use WizDevelop\PhpMonad\Tests\Assert;

use function WizDevelop\PhpMonad\Option\none;
use function WizDevelop\PhpMonad\Option\some;

#[TestDox('Option - UnwrapOrThrowTest')]
#[CoversClass(Option::class)]
final class UnwrapOrThrowTest extends TestCase
{
    #[Test]
    #[TestDox('some値の場合は値を返す')]
    public function some値の場合は値を返す(): void
    {
        $value = 'test';
        $option = some($value);
        $exception = new Exception('This exception should not be thrown');

        Assert::assertSame($value, $option->unwrapOrThrow($exception));
    }

    #[Test]
    #[TestDox('none値の場合は指定した例外をスローする')]
    public function none値の場合は指定した例外をスローする(): void
    {
        $option = none();
        $message = 'Custom exception message';
        $exception = new RuntimeException($message);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage($message);

        $option->unwrapOrThrow($exception);
    }

    #[Test]
    #[TestDox('none値の場合はカスタム例外をスローできる')]
    public function none値の場合はカスタム例外をスローできる(): void
    {
        $option = none();
        $customException = new class ('Custom exception') extends Exception {
        };

        $this->expectException($customException::class);
        $this->expectExceptionMessage('Custom exception');

        $option->unwrapOrThrow($customException);
    }
}
