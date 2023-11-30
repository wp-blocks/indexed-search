<?php

namespace WpBlocks\Search\Support;

interface TokenizerInterface
{
    /**
     * @param string   $text
     * @param string[] $stopwords
     *
     * @return TokenInterface[]
     */
    public function tokenize(string $text, array $stopwords): array;

    public function getPattern();
}
