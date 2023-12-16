<?php

namespace IndexedSearch\Stemmer;

interface Stemmer
{
    public static function stem($word);
}
