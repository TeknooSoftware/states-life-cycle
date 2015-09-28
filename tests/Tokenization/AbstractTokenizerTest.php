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
    public function testGetTokenBadArgument()
    {
        $this->build()->getToken(new \stdClass());
    }

    public function testGetToken()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $this->assertTrue(is_string($this->build()->getToken($instance)));
    }
}