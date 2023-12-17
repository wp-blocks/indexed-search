<?php

namespace IndexedSearch\Helpers;

class Str
{
    /**
     * Inspired by TNTSearch
     * https://github.com/teamtnt/tntsearch/blob/c8863c626a47bcb73f860abfe8eed9fb3cde3be8/src/Support/Tokenizer.php
     */
    protected static string $splitWordsPattern = '/[^\p{L}\p{N}\p{Pc}\p{Pd}@]+/u';

    /**
     * @return array<int,string>
     */
    public static function splitOnWhitespace(string $text): array
    {
        $result = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);

        if ($result === false) {
            throw new \IndexedSearch\Exceptions\TokenizationException();
        }

        return $result;
    }

    /**
     * @return array<int,string>
     */
    public static function splitWords(string $text): array
    {
        $result = preg_split(self::$splitWordsPattern, $text, -1, PREG_SPLIT_NO_EMPTY);

        if ($result === false) {
            throw new \IndexedSearch\Exceptions\TokenizationException();
        }

        return $result;
    }
}
