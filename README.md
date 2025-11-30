# PHP Monad

[![Packagist Version](https://img.shields.io/packagist/v/wiz-develop/php-monad)](https://packagist.org/packages/wiz-develop/php-monad)
[![PHP Version](https://img.shields.io/packagist/php-v/wiz-develop/php-monad)](https://packagist.org/packages/wiz-develop/php-monad)
[![PHPStan](https://github.com/wiz-develop/php-monad/actions/workflows/phpstan.yml/badge.svg)](https://github.com/wiz-develop/php-monad/actions/workflows/phpstan.yml)
[![Documentation](https://github.com/wiz-develop/php-monad/actions/workflows/deploy-docs.yml/badge.svg)](https://github.com/wiz-develop/php-monad/actions/workflows/deploy-docs.yml)
[![License](https://img.shields.io/packagist/l/wiz-develop/php-monad)](https://github.com/wiz-develop/php-monad/blob/main/LICENSE)

関数型プログラミングのモナド概念を PHP で実装したライブラリです。Rust の `Option` / `Result` 型に着想を得ています。

## インストール

```bash
composer require wiz-develop/php-monad
```

## 使用例

### Option

```php
use function WizDevelop\PhpMonad\Option\{some, none, fromValue};

$name = fromValue($user['name'] ?? null)
    ->map(fn($n) => strtoupper($n))
    ->filter(fn($n) => strlen($n) > 0)
    ->unwrapOr('Anonymous');
```

### Result

```php
use function WizDevelop\PhpMonad\Result\{ok, err, fromThrowable};

$result = fromThrowable(
    fn() => json_decode($json, flags: JSON_THROW_ON_ERROR),
    fn($e) => "Parse error: {$e->getMessage()}"
);

$data = $result->map(fn($d) => $d['key'])->unwrapOr(null);
```

## ドキュメント

詳細なガイドと API リファレンスは [ドキュメントサイト](https://wiz-develop.github.io/php-monad/) を参照してください。

## 要件

- PHP 8.3 以上

## ライセンス

MIT License
