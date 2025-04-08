<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad\Tests\Unit;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use WizDevelop\PhpMonad\Result;

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
