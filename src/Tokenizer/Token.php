<?php

namespace IndexedSearch\Tokenizer;

class Token
{
    private bool $isMetaword;

    private int $position;

    private string $value;

    public function __construct(int $position, string $value, bool $isMetaword = false)
    {
        $this->isMetaword = $isMetaword;
        $this->position = $position;
        $this->value = $value;
    }

    public function getIsMetaword(): bool
    {
        return $this->isMetaword;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
