<?php

namespace WpBlocks\Search\Tokenizer;

use WpBlocks\Search\Helpers\Str;

class Tokenizer
{
    private string $text;

    private int $cursor = 0;

    public function __construct($text)
    {
        Str::splitOnWhitespace($text);
        $this->text = $text;
    }

    public function getToken(): Token
    {
        return new Token($this->cursor, 'test');
    }
}
