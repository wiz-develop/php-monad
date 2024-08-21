<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad\Tests;

use EndouMame\PhpMonad\Option;
use EndouMame\PhpMonad\Result;

/**
 * @return Option<int>
 */
function parseIntM(string $value): Option
{
    return ctype_digit($value)
        ? Option\some((int)$value)
        : Option\none();
}

$result1 = parseIntM('123'); // => Some(123)
$result2 = parseIntM('abc'); // => None

// 数を2倍にしてモナドにくるんで返す関数
$f = static fn (int $n) => Option\some($n * 2);

$result1a = $result1->andThen(static fn (int $n) => Option\some($n * 2)); // => Some(246)

$result2a = $result2->andThen($f); // => None

$g = Option\some(0);
$result2a = $result2->and($g); // => Some(0)

$value = match (true) {
    $result2a instanceof Option\Some => $result2a->unwrap(),
    $result2a instanceof Option\None => 123,
};

/**
 * @return Result<int,string>
 */
function parseIntM2(string $value): Result
{
    return ctype_digit($value)
        ? Result\ok((int)$value)
        : Result\err("'{$value}' is not a digit.");
}

$result3 = parseIntM2('123'); // => Ok(123)

$unwrap = match (true) {
    $result3 instanceof Result\Ok => $result3->unwrap(),
    $result3 instanceof Result\Err => $result3->unwrapErr(),
};
