<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad\Tests\Unit;

use EndouMame\PhpMonad\Result;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

/**
 * @extends MonadTest<Result>
 */
#[TestDox('Result - MonadTest')]
#[CoversClass(Result::class)]
final class ResultTest extends MonadTest
{
    /**
     * @return iterable<array{Result<string,string>}>
     */
    #[Override]
    public static function monadsProvider(): iterable
    {
        yield 'ok' => [Result\ok('Ok')];
        yield 'err' => [Result\err('Err')];
    }
}
