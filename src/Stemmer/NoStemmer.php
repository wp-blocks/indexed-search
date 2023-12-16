<?php

namespace IndexedSearch\Stemmer;

class NoStemmer implements Stemmer
{
    public static function stem($word)
    {
        return $word;
    }
}
