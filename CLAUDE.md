# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## プロジェクト概要

PHP で関数型プログラミングのモナド概念を実装したライブラリ。Rust の `Option` と `Result` 型に着想を得ている。

## 開発コマンド

### 静的解析

```bash
vendor/bin/phpstan --configuration=phpstan.neon.dist --memory-limit=1G
```

### テスト

```bash
# 全テスト実行
vendor/bin/phpunit --configuration=phpunit.xml.dist --testdox --colors=always

# 特定テストファイルの実行
vendor/bin/phpunit tests/Unit/Option/SomeTest.php

# 特定テストメソッドの実行
vendor/bin/phpunit --filter testMethodName
```

### コードフォーマット

```bash
vendor/bin/php-cs-fixer fix
```

## アーキテクチャ

### モナド階層

```
Monad (interface)
├── Option (interface) - Maybe モナド
│   ├── Some<T>        - 値を保持
│   └── None           - 値なし
└── Result (interface) - Either モナド
    ├── Ok<T>          - 成功値
    └── Err<E>         - エラー値
```

### ファイル構成

- `src/Monad.php` - 基底インターフェース (`unit`, `andThen`)
- `src/Option.php`, `src/Result.php` - sealed インターフェース
- `src/Option/`, `src/Result/` - 具象クラスとヘルパー関数
- `src/functions.php` - 全ヘルパー関数のオートロード

### ヘルパー関数

```php
use function WizDevelop\PhpMonad\Option\{some, none, fromValue, of, tryOf, flatten, transpose};
use function WizDevelop\PhpMonad\Result\{ok, err, fromThrowable, flatten, transpose, combine};
```

## コーディング規約

- PHP 8.3 以上必須
- PHPStan レベル max
- `#[Sealed]` 属性で継承制限
- `#[Override]` 属性必須
- `readonly class` で不変性を保証
- テンプレート型による型安全性 (`@template T`)
