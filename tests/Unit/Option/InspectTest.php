<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad\Tests\Unit;

use EndouMame\PhpMonad\Option;
use EndouMame\PhpMonad\Tests\Assert;
use EndouMame\PhpMonad\Tests\Provider\OptionProvider;
use EndouMame\PhpMonad\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox('Option - InspectTest')]
#[CoversClass(Option::class)]
final class InspectTest extends TestCase
{
    use OptionProvider;

    #[Test]
    #[TestDox('inspectSome test')]
    #[DataProvider('values')]
    public function inspectSome(mixed $value): void
    {
        $option = Option\some($value);

        $calls = [];
        $result = $option->inspect(static function (mixed $value) use (&$calls): void {
            $calls[] = $value;
        });

        Assert::assertSame($option, $result);
        Assert::assertSame([$value], $calls);
    }

    #[Test]
    #[TestDox('inspectNone test')]
    public function inspectNone(): void
    {
        $option = Option\none();

        $calls = [];
        $result = $option->inspect(static function (mixed $value) use (&$calls): void {
            $calls[] = $value;
        });

        Assert::assertSame($option, $result);
        Assert::assertSame([], $calls);
    }
}
