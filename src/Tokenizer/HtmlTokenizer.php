<?php

namespace WpBlocks\Search\Tokenizer;

use WpBlocks\Search\Compat\WP_HTML_Tag_Processor;
use WpBlocks\Search\Helpers\Str;

class HtmlTokenizer
{
    private WP_HTML_Tag_Processor $processor;

    private int $cursor = 0;

    private int $lastTokenEndsAt = 0;

    private ?string $chunk = null;

    /**
     * @var string[]
     */
    private array $buffer = [];

    public function __construct(string $html)
    {
        $this->processor = new WP_HTML_Tag_Processor($html);
    }

    public function nextToken(): ?Token
    {
        // Could be text before the first tag?

        if (count($this->buffer) > 0) {
            $token = array_shift($this->buffer);
            return new Token($this->cursor, $token);
        } elseif ($this->nextTag()) {
            $this->processTag();
            $words = [];

            if ($this->chunk !== null) {
                $words = Str::splitWords($this->chunk);
                if (count($words) > 0) {
                    $this->buffer = $words;
                }
            }

            $tag = $this->processor->get_tag();

            // This actually should never happen because of previous guards, the logic should be
            // modified to reflect reality.
            if ($tag === null) {
                return null;
            }

            return new Token($this->cursor, $tag, true);
        }

        // Could be text after the last tag?

        return null;
    }

    private function nextTag(): bool
    {
        return $this->processor->next_tag(['tag_closers' => 'visit']);
    }

    /**
     * @return void
     */
    private function processTag()
    {
        $tokenStartsAt = $this->processor->get_token_starts_at();
        $tokenEndsAt = $this->processor->get_token_ends_at();

        // Need to check if there is a gap between tags;

        if ($this->lastTokenEndsAt !== 0) {
            $maybeChunkStartsAt = $this->lastTokenEndsAt + 1;

            if ($tokenStartsAt !== $maybeChunkStartsAt) {
                $length = $tokenStartsAt - $maybeChunkStartsAt;
                $this->chunk = $this->processor->substr($maybeChunkStartsAt, $length);
            } else {
                $this->chunk = null;
            }
        }

        $this->lastTokenEndsAt = $tokenEndsAt;
    }
}
