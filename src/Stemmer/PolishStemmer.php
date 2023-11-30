<?php

namespace WpBlocks\Search\Stemmer;

/*
 * @link https://github.com/Tutanchamon/pl_stemmer
 *
 * Simple stemmer for polish language based on pl_stemmer by Błażej Kubiński.
 * Originally written by Nenad Tičarić
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

class PolishStemmer implements Stemmer
{
    public static function removeNouns($word)
    {
        if (strlen($word) > 7 && in_array(mb_substr($word, -5), ['zacja', 'zacją', 'zacji'])) {
            return mb_substr($word, 0, -4);
        }
        if (strlen($word) > 6 && in_array(mb_substr($word, -4), ['acja', 'acji', 'acją', 'tach', 'anie', 'enie', 'eniu', 'aniu'])) {
            return mb_substr($word, 0, -4);
        }
        if (strlen($word) > 6 && (mb_substr($word, -4) == 'tyka')) {
            return mb_substr($word, 0, -2);
        }
        if (strlen($word) > 5 && in_array(mb_substr($word, -3), ['ach', 'ami', 'nia', 'niu', 'cia', 'ciu'])) {
            return mb_substr($word, 0, -3);
        }
        if (strlen($word) > 5 && in_array(mb_substr($word, -3), ['cji', 'cja', 'cją'])) {
            return mb_substr($word, 0, -2);
        }
        if (strlen($word) > 5 && in_array(mb_substr($word, -2), ['ce', 'ta'])) {
            return mb_substr($word, 0, -2);
        }
        return $word;
    }

    public static function removeDiminutive($word)
    {
        if (strlen($word) > 6) {
            if (in_array(mb_substr($word, -5), ['eczek', 'iczek', 'iszek', 'aszek', 'uszek'])) {
                return mb_substr($word, 0, -5);
            }
            if (in_array(mb_substr($word, -4), ['enek', 'ejek', 'erek'])) {
                return mb_substr($word, 0, -2);
            }
        }
        if (strlen($word) > 4) {
            if (in_array(mb_substr($word, -2), ['ek', 'ak'])) {
                return mb_substr($word, 0, -2);
            }
        }
        return $word;
    }

    public static function removeAdjectiveEnds($word)
    {
        if (strlen($word) > 7 && (mb_substr($word, 0, 3) == 'naj') && in_array(mb_substr($word, -3), ['sze', 'szy'])) {
            return mb_substr($word, 3, -3);
        }
        if (strlen($word) > 7 && (mb_substr($word, 0, 3) == 'naj') && (mb_substr($word, 0, 5) == 'szych')) {
            return mb_substr($word, 3, -5);
        }
        if (strlen($word) > 6 && (mb_substr($word, -4) == 'czny')) {
            return mb_substr($word, 0, -4);
        }
        if (strlen($word) > 5 && in_array(mb_substr($word, -3), ['owy', 'owa', 'owe', 'ych', 'ego'])) {
            return mb_substr($word, 0, -3);
        }
        if (strlen($word) > 5 && (mb_substr($word, -2) == 'ej')) {
            return mb_substr($word, 0, -2);
        }
        return $word;
    }

    public static function removeVerbsEnds($word)
    {
        if (strlen($word) > 5 && (mb_substr($word, -3) == 'bym')) {
            return mb_substr($word, 0, -3);
        }
        if (strlen($word) > 5 && in_array(mb_substr($word, -3), ['esz', 'asz', 'cie', 'eść', 'aść', 'łem', 'amy', 'emy'])) {
            return mb_substr($word, 0, -3);
        }
        if (strlen($word) > 3 && in_array(mb_substr($word, -3), ['esz', 'asz', 'eść', 'aść', 'eć', 'ać'])) {
            return mb_substr($word, 0, -2);
        }
        if (strlen($word) > 3 && in_array(mb_substr($word, -2), ['aj'])) {
            return mb_substr($word, 0, -1);
        }
        if (strlen($word) > 3 && in_array(mb_substr($word, -2), ['ać', 'em', 'am', 'ał', 'ił', 'ić', 'ąc'])) {
            return mb_substr($word, 0, -2);
        }
        return $word;
    }

    public static function removeAdverbsEnds($word)
    {
        if (strlen($word) > 4 && in_array(mb_substr($word, -3), ['nie', 'wie', 'rze'])) {
            return mb_substr($word, 0, -2);
        }
        return $word;
    }

    public static function removePluralForms($word)
    {
        if (strlen($word) > 4 && in_array(mb_substr($word, -2), ['ów', 'om'])) {
            return mb_substr($word, 0, -2);
        }
        if (strlen($word) > 4 && (mb_substr($word, -3) == 'ami')) {
            return mb_substr($word, 0, -3);
        }
        return $word;
    }

    public static function removeGeneralEnds($word)
    {
        if (strlen($word) > 4 && in_array(substr($word, -2), ['ia', 'ie'])) {
            return substr($word, 0, -2);
        }
        if (strlen($word) > 4 && in_array(substr($word, -1), ['u', 'ą', 'i', 'a', 'ę', 'y', 'ę', 'ł'])) {
            return substr($word, 0, -1);
        }
        return $word;
    }

    public static function stem($word)
    {
        $word = mb_strtolower($word);

        $stem = $word;

        $stem = self::removeNouns($stem);
        $stem = self::removeDiminutive($stem);
        $stem = self::removeAdjectiveEnds($stem);
        $stem = self::removeVerbsEnds($stem);
        $stem = self::removeAdverbsEnds($stem);
        $stem = self::removePluralForms($stem);
        $stem = self::removeGeneralEnds($stem);

        return $stem;
    }
}
