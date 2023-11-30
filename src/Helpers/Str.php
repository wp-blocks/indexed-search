<?php

namespace WpBlocks\Search\Helpers;

class Str
{
    /**
     * @return string[]
     */
    public static function splitOnWhitespace(string $text): array
    {
        return preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
    }
}
