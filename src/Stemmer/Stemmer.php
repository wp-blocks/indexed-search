<?php

namespace WpBlocks\Search\Stemmer;

interface Stemmer
{
    public static function stem($word);
}
