<?php

/*
 * This is a reimplementation of AR-PHP Arabic stemmer.
 * The original author is Khaled Al-Sham'aa <khaled@ar-php.org>
 *
 * Simple stemmer for arabic language rewritten by Nenad Tičarić
 *
 * @link https://github.com/teamtnt/tntsearch
 *
 * Copyright (c) 2016 Nenad Tičarić nticaric@gmail.com
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR
 * OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

namespace IndexedSearch\Stemmer;

class ArabicStemmer implements Stemmer
{
    private static $_verbPre  = 'وأسفلي';

    private static $_verbPost = 'ومكانيه';

    private static $_verbMay;

    private static $_verbMaxPre  = 4;

    private static $_verbMaxPost = 6;

    private static $_verbMinStem = 2;

    private static $_nounPre  = 'ابفكلوأ';

    private static $_nounPost = 'اتةكمنهوي';

    private static $_nounMay;

    private static $_nounMaxPre  = 4;

    private static $_nounMaxPost = 6;

    private static $_nounMinStem = 2;

    /**
     * Loads initialize values
     *
     * @ignore
     */
    public function __construct()
    {
        self::$_verbMay = self::$_verbPre . self::$_verbPost;
        self::$_nounMay = self::$_nounPre . self::$_nounPost;
    }

    /**
     * Get rough stem of the given Arabic word
     *
     * @param string $word Arabic word you would like to get its stem
     *
     * @return string Arabic stem of the word
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public static function stem($word)
    {
        $nounStem = self::roughStem(
            $word,
            self::$_nounMay,
            self::$_nounPre,
            self::$_nounPost,
            self::$_nounMaxPre,
            self::$_nounMaxPost,
            self::$_nounMinStem
        );
        $verbStem = self::roughStem(
            $word,
            self::$_verbMay,
            self::$_verbPre,
            self::$_verbPost,
            self::$_verbMaxPre,
            self::$_verbMaxPost,
            self::$_verbMinStem
        );

        if (mb_strlen($nounStem, 'UTF-8') < mb_strlen($verbStem, 'UTF-8')) {
            $stem = $nounStem;
        } else {
            $stem = $verbStem;
        }

        return $stem;
    }

    /**
     * Get rough stem of the given Arabic word (under specific rules)
     *
     * @param string  $word      Arabic word you would like to get its stem
     * @param string  $notChars  Arabic chars those can't be in postfix or prefix
     * @param string  $preChars  Arabic chars those may exists in the prefix
     * @param string  $postChars Arabic chars those may exists in the postfix
     * @param integer $maxPre    Max prefix length
     * @param integer $maxPost   Max postfix length
     * @param integer $minStem   Min stem length
     *
     * @return string Arabic stem of the word under giving rules
     *
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    protected static function roughStem(
        $word,
        $notChars,
        $preChars,
        $postChars,
        $maxPre,
        $maxPost,
        $minStem
    ) {
        $right = -1;
        $left  = -1;
        $max   = mb_strlen($word, 'UTF-8');

        for ($i = 0; $i < $max; $i++) {
            $needle = mb_substr($word, $i, 1, 'UTF-8');
            if (mb_strpos($notChars, $needle, 0, 'UTF-8') === false) {
                if ($right == -1) {
                    $right = $i;
                }
                $left = $i;
            }
        }

        if ($right > $maxPre) {
            $right = $maxPre;
        }

        if ($max - $left - 1 > $maxPost) {
            $left = $max - $maxPost - 1;
        }

        for ($i = 0; $i < $right; $i++) {
            $needle = mb_substr($word, $i, 1, 'UTF-8');
            if (mb_strpos($preChars, $needle, 0, 'UTF-8') === false) {
                $right = $i;
                break;
            }
        }

        for ($i = $max - 1; $i > $left; $i--) {
            $needle = mb_substr($word, $i, 1, 'UTF-8');
            if (mb_strpos($postChars, $needle, 0, 'UTF-8') === false) {
                $left = $i;
                break;
            }
        }

        if ($left - $right >= $minStem) {
            $stem = mb_substr($word, $right, $left - $right + 1, 'UTF-8');
        } else {
            $stem = null;
        }

        return $stem;
    }
}
