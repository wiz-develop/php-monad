<?php

declare(strict_types=1);

namespace EndouMame\PhpMonad;

/**
 * テスト
 */
final readonly class Test
{
    public function __construct(
        public string $id
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
