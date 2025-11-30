# ヘルパー関数

PHP Monad は、モナドを簡単に作成・操作するためのヘルパー関数を提供しています。

## Option ヘルパー関数

```php
use function WizDevelop\PhpMonad\Option\{
    some,
    none,
    fromValue,
    of,
    tryOf,
    flatten,
    transpose
};
```

### some

値を持つ Some を作成します。

```php
/**
 * @template T
 * @param T $value
 * @return Some<T>
 */
function some(mixed $value): Some
```

#### 使用例

```php
$opt = some(42);        // Some<int>
$opt = some('hello');   // Some<string>
$opt = some([1, 2, 3]); // Some<array>
```

### none

値を持たない None を作成します。

```php
function none(): None
```

#### 使用例

```php
$opt = none();  // None
```

### fromValue

値を Option に変換します。指定した値（デフォルトは null）と等しい場合は None になります。

```php
/**
 * @template U
 * @template NoneValue
 * @param U $value
 * @param NoneValue|null $noneValue
 * @return Option<U>
 */
function fromValue($value, mixed $noneValue = null): Option
```

#### 使用例

```php
$opt = fromValue($user);              // null なら None
$opt = fromValue($count, 0);          // 0 なら None
$opt = fromValue($name, '');          // 空文字なら None
$opt = fromValue($data, false);       // false なら None
```

### of

関数を実行し、結果を Option に変換します。

```php
/**
 * @template U
 * @template NoneValue
 * @param callable(): U $callback
 * @param NoneValue|null $noneValue
 * @return Option<U>
 */
function of(callable $callback, mixed $noneValue = null): Option
```

#### 使用例

```php
$opt = of(fn() => getUser($id));
$opt = of(fn() => findByKey($array, $key), false);
```

### tryOf

関数を実行し、例外が発生した場合は None を返します。

```php
/**
 * @template U
 * @template NoneValue
 * @template E of Throwable
 * @param callable(): U $callback
 * @param NoneValue|null $noneValue
 * @param class-string<E> $exceptionClass
 * @return Option<U>
 * @throws Throwable 指定したクラス以外の例外は再スロー
 */
function tryOf(
    callable $callback,
    mixed $noneValue = null,
    string $exceptionClass = Exception::class
): Option
```

#### 使用例

```php
$date = tryOf(
    fn() => new DateTimeImmutable($input),
    null,
    DateMalformedStringException::class
);

$json = tryOf(
    fn() => json_decode($str, flags: JSON_THROW_ON_ERROR),
    null,
    JsonException::class
);
```

### flatten

`Option<Option<T>>` を `Option<T>` に平坦化します。

```php
/**
 * @template U
 * @param Option<Option<U>> $option
 * @return Option<U>
 */
function flatten(Option $option): Option
```

#### 使用例

```php
$nested = some(some(42));
$flat = flatten($nested);  // Some(42)

$nested = some(none());
$flat = flatten($nested);  // None
```

### transpose

`Option<Result<T, E>>` を `Result<Option<T>, E>` に変換します。

```php
/**
 * @template U
 * @template E
 * @param Option<Result<U, E>> $option
 * @return Result<Option<U>, E>
 */
function transpose(Option $option): Result
```

#### 使用例

```php
use function WizDevelop\PhpMonad\Result\{ok, err};

transpose(some(ok(42)));    // Ok(Some(42))
transpose(some(err('e')));  // Err('e')
transpose(none());          // Ok(None)
```

## Result ヘルパー関数

```php
use function WizDevelop\PhpMonad\Result\{
    ok,
    err,
    fromThrowable,
    flatten,
    transpose,
    combine
};
```

### ok

成功値を持つ Ok を作成します。

```php
/**
 * @template U
 * @param U $value
 * @return Ok<U>
 */
function ok(mixed $value = true): Ok
```

#### 使用例

```php
$result = ok(42);       // Ok<int>
$result = ok('data');   // Ok<string>
$result = ok();         // Ok<true>
```

### err

エラー値を持つ Err を作成します。

```php
/**
 * @template F
 * @param F $value
 * @return Err<F>
 */
function err(mixed $value): Err
```

#### 使用例

```php
$result = err('エラー');                // Err<string>
$result = err(['code' => 'E001']);      // Err<array>
$result = err(new Exception('失敗'));   // Err<Exception>
```

### fromThrowable

例外をスローする可能性のある処理を Result に変換します。

```php
/**
 * @template T
 * @template E
 * @param Closure(): T $closure
 * @param Closure(Throwable): E $errorHandler
 * @return Result<T, E>
 */
function fromThrowable(Closure $closure, Closure $errorHandler): Result
```

#### 使用例

```php
$result = fromThrowable(
    fn() => json_decode($json, flags: JSON_THROW_ON_ERROR),
    fn($e) => "パースエラー: {$e->getMessage()}"
);

$result = fromThrowable(
    fn() => file_get_contents($path),
    fn($e) => ['type' => 'io_error', 'message' => $e->getMessage()]
);
```

### flatten

`Result<Result<T, E>, E>` を `Result<T, E>` に平坦化します。

```php
/**
 * @template T
 * @template E
 * @param Result<Result<T, E>, E> $result
 * @return Result<T, E>
 */
function flatten(Result $result): Result
```

#### 使用例

```php
$nested = ok(ok(42));
$flat = flatten($nested);  // Ok(42)

$nested = ok(err('inner'));
$flat = flatten($nested);  // Err('inner')

$nested = err('outer');
$flat = flatten($nested);  // Err('outer')
```

### transpose

`Result<Option<T>, E>` を `Option<Result<T, E>>` に変換します。

```php
/**
 * @template U
 * @template F
 * @param Result<Option<U>, F> $result
 * @return Option<Result<U, F>>
 */
function transpose(Result $result): Option
```

#### 使用例

```php
use function WizDevelop\PhpMonad\Option\{some, none};

transpose(ok(some(42)));   // Some(Ok(42))
transpose(ok(none()));     // None
transpose(err('error'));   // Some(Err('error'))
```

### combine

複数の Result を検証し、全て成功なら Ok、1 つでも失敗なら全エラーを Err で返します。

```php
/**
 * @template T
 * @template E
 * @param Result<T, E> ...$results
 * @return Result<bool, non-empty-list<E>>
 */
function combine(Result ...$results): Result
```

#### 使用例

```php
// 全て成功
$result = combine(ok(1), ok(2), ok(3));
$result->isOk();  // true
$result->unwrap();  // true

// 一部失敗
$result = combine(
    ok(1),
    err('エラー1'),
    ok(2),
    err('エラー2')
);

$result->isErr();  // true
$result->unwrapErr();  // ['エラー1', 'エラー2']
```

::: tip バリデーションに便利
`combine` はフォームバリデーションで特に便利です。

```php
$result = combine(
    validateEmail($email),
    validatePassword($password),
    validateAge($age)
);

if ($result->isErr()) {
    $errors = $result->unwrapErr();
    // 全てのエラーメッセージを表示
}
```
:::
