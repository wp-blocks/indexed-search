<?php

namespace IndexedSearch\Stemmer;

/*
 * Simple stemmer for ukrainian language originally written by Nenad Tičarić
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

class UkrainianStemmer implements Stemmer
{
    private static $VOWEL = '/аеиоуюяіїє/u';

    /* http://uk.wikipedia.org/wiki/Голосний_звук */
    // var $PERFECTIVEGROUND = '/((ив|ивши|ившись|ыв|ывши|ывшись((?<=[ая])(в|вши|вшись)))$/';
    private static $PERFECTIVEGROUND = '/(ив|ивши|ившись|ів|івши|івшись((?<=[ая|я])(в|вши|вшись)))$/u';

    private static $REFLEXIVE = '/(с[яьи])$/u'; // http://uk.wikipedia.org/wiki/Рефлексивне_дієслово

    private static $ADJECTIVE = '/(ими|ій|ий|а|е|ова|ове|ів|є|їй|єє|еє|я|ім|ем|им|ім|их|іх|ою|йми|іми|у|ю|ого|ому|ої)$/u'; //http://uk.wikipedia.org/wiki/Прикметник + http://wapedia.mobi/uk/Прикметник

    private static $PARTICIPLE = '/(ий|ого|ому|им|ім|а|ій|у|ою|ій|і|их|йми|их)$/u'; //http://uk.wikipedia.org/wiki/Дієприкметник

    private static $VERB = '/(сь|ся|ив|ать|ять|у|ю|ав|али|учи|ячи|вши|ши|е|ме|ати|яти|є)$/u'; //http://uk.wikipedia.org/wiki/Дієслово

    private static $NOUN = '/(а|ев|ов|е|ями|ами|еи|и|ей|ой|ий|й|иям|ям|ием|ем|ам|ом|о|у|ах|иях|ях|ы|ь|ию|ью|ю|ия|ья|я|і|ові|ї|ею|єю|ою|є|еві|ем|єм|ів|їв|\'ю)$/u'; //http://uk.wikipedia.org/wiki/Іменник

    private static $RVRE = '/^(.*?[аеиоуюяіїє])(.*)$/u';

    private static $DERIVATIONAL = '/[^аеиоуюяіїє][аеиоуюяіїє]+[^аеиоуюяіїє]+[аеиоуюяіїє].*(?<=о)сть?$/u';

    private static function s(&$s, $re, $to)
    {
        $orig = $s;
        $s    = preg_replace($re, $to, $s);
        return $orig !== $s;
    }

    private static function m($s, $re)
    {
        return preg_match($re, $s);
    }

    public static function stem($word)
    {
        $word = mb_strtolower($word);

        $stem = $word;

        do {
            if (!preg_match(self::$RVRE, $word, $p)) {
                break;
            }
            $start = $p[1];
            $RV    = $p[2];
            if (!$RV) {
                break;
            }

            // Step 1
            if (!self::s($RV, self::$PERFECTIVEGROUND, '')) {
                self::s($RV, self::$REFLEXIVE, '');

                if (self::s($RV, self::$ADJECTIVE, '')) {
                    self::s($RV, self::$PARTICIPLE, '');
                } else {
                    if (!self::s($RV, self::$VERB, '')) {
                        self::s($RV, self::$NOUN, '');
                    }
                }
            }

            // Step 2
            self::s($RV, '/[и|i]$/u', '');

            // Step 3
            if (self::m($RV, self::$DERIVATIONAL)) {
                self::s($RV, '/сть?$/u', '');
            }

            // Step 4
            if (!self::s($RV, '/ь$/u', '')) {
                self::s($RV, '/ейше?/u', '');
                self::s($RV, '/нн$/u', 'н');
            }

            $stem = $start . $RV;
        } while (false);

        return $stem;
    }
}
