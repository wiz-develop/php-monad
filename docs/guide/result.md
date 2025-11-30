# Result モナド

Result は「成功または失敗」を型で表現するモナドです。Rust の `Result<T, E>` に着想を得ています。

## 概要

Result には 2 つの状態があります。

- `Ok<T>`: 成功値 `T` を保持している状態
- `Err<E>`: エラー値 `E` を保持している状態

```php
use function WizDevelop\PhpMonad\Result\{ok, err};

$success = ok(42);        // Ok<int> - 成功
$failure = err('error');  // Err<string> - 失敗
```

## Result を作成する

### ok / err

最も基本的な作成方法です。

```php
use function WizDevelop\PhpMonad\Result\{ok, err};

$success = ok(42);           // Ok<int>
$successBool = ok();         // Ok<true>（引数省略時は true）
$failure = err('error');     // Err<string>
```

### fromThrowable

例外をスローする可能性のある処理を Result に変換します。

```php
use function WizDevelop\PhpMonad\Result\fromThrowable;

$result = fromThrowable(
    fn() => json_decode($json, flags: JSON_THROW_ON_ERROR),
    fn(Throwable $e) => "パースエラー: {$e->getMessage()}"
);

// 成功時: Ok(デコード結果)
// 失敗時: Err("パースエラー: ...")
```

## 状態を判定する

### isOk / isErr

```php
$result = ok(42);

if ($result->isOk()) {
    // 成功の場合の処理
}

if ($result->isErr()) {
    // 失敗の場合の処理
}
```

### isOkAnd / isErrAnd

値があり、かつ述語を満たす場合に `true` を返します。

```php
$result = ok(10);

$result->isOkAnd(fn($x) => $x > 5);   // true
$result->isOkAnd(fn($x) => $x > 15);  // false

err('e')->isOkAnd(fn($x) => true);    // false
```

```php
$result = err('not found');

$result->isErrAnd(fn($e) => str_contains($e, 'not'));  // true
```

## 値を取得する

### unwrap

成功値を取得します。Err の場合は例外をスローします。

```php
$result = ok(42);
$value = $result->unwrap();  // 42

$err = err('error');
$err->unwrap();  // 例外をスロー
```

### unwrapErr

エラー値を取得します。Ok の場合は例外をスローします。

```php
$result = err('error');
$error = $result->unwrapErr();  // 'error'

$ok = ok(42);
$ok->unwrapErr();  // RuntimeException をスロー
```

### expect

カスタムエラーメッセージで成功値を取得します。

```php
$result = ok(42);
$value = $result->expect('値が必要です');  // 42

$err = err('error');
$err->expect('値が必要です');  // RuntimeException: 値が必要です
```

### unwrapOr

デフォルト値を指定して取得します。

```php
$result = ok(42);
$result->unwrapOr(0);   // 42

$err = err('error');
$err->unwrapOr(0);      // 0
```

### unwrapOrElse

デフォルト値を遅延評価で取得します。エラー値を引数として受け取れます。

```php
$err = err('not found');
$err->unwrapOrElse(fn($e) => "エラー: $e");  // "エラー: not found"
```

### unwrapOrThrow

Err の場合に指定した例外をスローします。

```php
$err = err('error');
$err->unwrapOrThrow(new NotFoundException('リソースが見つかりません'));
```

## 値を変換する

### map

成功値を変換します。Err の場合はスキップされます。

```php
$result = ok(5);

$mapped = $result
    ->map(fn($x) => $x * 2)     // Ok(10)
    ->map(fn($x) => "値: $x");  // Ok("値: 10")

$err = err('error');
$err->map(fn($x) => $x * 2);    // Err('error')（スキップ）
```

### mapErr

エラー値を変換します。Ok の場合はスキップされます。

```php
$err = err('not found');
$mapped = $err->mapErr(fn($e) => strtoupper($e));  // Err('NOT FOUND')

$ok = ok(42);
$ok->mapErr(fn($e) => strtoupper($e));  // Ok(42)（スキップ）
```

### mapOr

成功値を変換するか、デフォルト値を返します。

```php
$result = ok(5);
$result->mapOr(fn($x) => $x * 2, 0);   // 10

$err = err('error');
$err->mapOr(fn($x) => $x * 2, 0);      // 0
```

### mapOrElse

成功値を変換するか、エラーからデフォルト値を計算します。

```php
$err = err('not found');
$result = $err->mapOrElse(
    fn($x) => $x * 2,
    fn($e) => strlen($e)  // エラー文字列の長さ
);  // 9
```

### inspect / inspectErr

値を検査（副作用を実行）し、自身を返します。

```php
$result = ok(42)
    ->inspect(fn($x) => logger()->info("成功: $x"))
    ->map(fn($x) => $x * 2);

$err = err('error')
    ->inspectErr(fn($e) => logger()->error("失敗: $e"))
    ->mapErr(fn($e) => new Exception($e));
```

## 論理演算

### and

両方が Ok の場合、右側の Result を返します。

```php
$a = ok(1);
$b = ok(2);

$a->and($b);  // Ok(2)
$a->and(err('e'));  // Err('e')

err('e')->and($b);  // Err('e')
```

### andThen

成功値を受け取り Result を返す関数を適用します（flatMap）。

```php
function divide(int $a, int $b): Result {
    return $b === 0
        ? err('ゼロ除算')
        : ok($a / $b);
}

$result = ok(10)
    ->andThen(fn($x) => divide($x, 2))   // Ok(5)
    ->andThen(fn($x) => divide($x, 0));  // Err('ゼロ除算')
```

### or

左が Err なら右を返します。

```php
$a = ok(1);
$b = ok(2);

$a->or($b);        // Ok(1)
err('e')->or($b);  // Ok(2)
```

### orElse

左が Err なら右を遅延評価します。エラー値を引数として受け取れます。

```php
$err = err('primary failed');
$result = $err->orElse(fn($e) => ok("fallback for: $e"));
```

### orThrow

Err の場合に例外をスローし、Ok の場合はそのまま返します。

```php
$result = ok(42);
$result->orThrow(new Exception('エラー'));  // Ok(42)

$err = err('error');
$err->orThrow(new Exception('エラー'));  // Exception をスロー
```

## Option への変換

### ok

Ok を Some に、Err を None に変換します。

```php
$result = ok(42);
$opt = $result->ok();  // Some(42)

$err = err('error');
$opt = $err->ok();     // None
```

### err

Err を Some に、Ok を None に変換します。

```php
$result = ok(42);
$opt = $result->err();  // None

$err = err('error');
$opt = $err->err();     // Some('error')
```

## ユーティリティ関数

### flatten

`Result<Result<T, E>, E>` を `Result<T, E>` に平坦化します。

```php
use function WizDevelop\PhpMonad\Result\{ok, err, flatten};

$nested = ok(ok(42));
flatten($nested);  // Ok(42)

$nested2 = ok(err('inner error'));
flatten($nested2);  // Err('inner error')
```

### transpose

`Result<Option<T>, E>` を `Option<Result<T, E>>` に変換します。

```php
use function WizDevelop\PhpMonad\Result\{ok, err, transpose};
use function WizDevelop\PhpMonad\Option\{some, none};

transpose(ok(some(42)));   // Some(Ok(42))
transpose(ok(none()));     // None
transpose(err('error'));   // Some(Err('error'))
```

### combine

複数の Result を検証し、全て成功なら Ok、1 つでも失敗なら全エラーを Err で返します。

```php
use function WizDevelop\PhpMonad\Result\{ok, err, combine};

// 全て成功
$result = combine(ok(1), ok(2), ok(3));
$result->isOk();  // true

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

## イテレーション

Result は `IteratorAggregate` を実装しているため、foreach で使用できます。

```php
$result = ok(42);

foreach ($result as $value) {
    echo $value;  // 42
}

$err = err('error');

foreach ($err as $value) {
    // 実行されない
}
```

## 典型的なパターン

### 例外の置き換え

```php
// Before
function parseJson(string $json): array {
    try {
        return json_decode($json, true, flags: JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        throw new InvalidArgumentException("Invalid JSON: {$e->getMessage()}");
    }
}

// After
function parseJson(string $json): Result {
    return fromThrowable(
        fn() => json_decode($json, true, flags: JSON_THROW_ON_ERROR),
        fn($e) => "Invalid JSON: {$e->getMessage()}"
    );
}
```

### バリデーションパイプライン

```php
function validateAge(int $age): Result {
    if ($age < 0) {
        return err('年齢は 0 以上である必要があります');
    }
    if ($age > 150) {
        return err('年齢は 150 以下である必要があります');
    }
    return ok($age);
}

function validateName(string $name): Result {
    if (strlen($name) === 0) {
        return err('名前は必須です');
    }
    return ok($name);
}

// 複数のバリデーションを結合
$result = combine(
    validateAge($age),
    validateName($name)
);

if ($result->isErr()) {
    $errors = $result->unwrapErr();
    // ['年齢は 0 以上である必要があります', '名前は必須です']
}
```

### エラーの変換

```php
$result = fromThrowable(
    fn() => file_get_contents($path),
    fn($e) => ['code' => 'FILE_READ_ERROR', 'message' => $e->getMessage()]
)
->andThen(fn($content) => fromThrowable(
    fn() => json_decode($content, flags: JSON_THROW_ON_ERROR),
    fn($e) => ['code' => 'JSON_PARSE_ERROR', 'message' => $e->getMessage()]
))
->map(fn($data) => new Config($data));
```
