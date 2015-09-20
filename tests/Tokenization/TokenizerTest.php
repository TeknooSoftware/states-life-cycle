<?php

namespace UniAlteri\Tests\States\LifeCycle\Tokenization;

use UniAlteri\States\LifeCycle\Tokenization\Tokenizer;

/**
 * Class TokenizerTest
 *
 * @covers UniAlteri\States\LifeCycle\Tokenization\Tokenizer
 */
class TokenizerTest extends AbstractTokenizerTest
{
    /**
     * @return Tokenizer
     */
    public function build()
    {
        return new Tokenizer();
    }
}