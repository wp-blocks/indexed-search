<?php

namespace IndexedSearch\Tokenizer;

class TokenizerTest extends \Codeception\Test\Unit
{
    private ?Tokenizer $tokenizer = null;

    public function _begin()
    {
        $this->tokenizer = new Tokenizer('<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow"><h1>Hello</h1> World!</div>');
    }

    /**
     * @group tokenizer
     */
    public function test_tokenizer_initializes(): void
    {
        $tokenizer = new Tokenizer('<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow"><h1>Hello</h1> World!</div>');
        $this->assertInstanceOf(Tokenizer::class, $tokenizer);
    }
}
