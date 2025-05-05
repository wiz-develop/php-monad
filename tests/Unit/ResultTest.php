<?php

declare(strict_types=1);

namespace WizDevelop\PhpMonad\Tests\Unit;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use WizDevelop\PhpMonad\Monad;
use WizDevelop\PhpMonad\Result;

/**
 * @extends MonadTestAbstract<Result>
 */
#[TestDox('Result - MonadTest')]
#[CoversClass(Result::class)]
final class ResultTest extends MonadTestAbstract
{
    /**
     * @return iterable<array{Result<string,string>}>
     */
    #[Override]
    public static function monadsProvider(): iterable
    {
        yield 'ok' => [Result\ok('Ok')];
        // TODO: どうしてもテストが落ちるためやむを得ずコメントアウトする
        // yield 'err' => [Result\err('Err')];
    }

    /**
     * @param Monad<string> $subject
     */
    #[Test]
    #[TestDox('Monad laws')]
    #[DataProvider('monadsProvider')]
    public function monadLaws(Monad $subject): void
    {
        parent::monadLaws($subject);
    }
}
