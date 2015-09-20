<?php

namespace UniAlteri\Tests\States\LifeCycle\Tokenization;

use UniAlteri\States\LifeCycle\Tokenization\TokenizerInterface;

/**
 * Class AbstractTokenizerTest
 * @package UniAlteri\Tests\States\LifeCycle\Tokenization
 */
abstract class AbstractTokenizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return TokenizerInterface
     */
    abstract public function build();

    /**
     * @expectedException \TypeError
     */
    public function testGetStatedClassTokenBadArg()
    {
        $this->build()->getStatedClassToken(new \stdClass());
    }

    public function testGetStatedClassToken()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\Tokenization\TokenizerInterface');
        $this->assertTrue(is_string($this->build()->getStatedClassToken($instance)));
    }
}