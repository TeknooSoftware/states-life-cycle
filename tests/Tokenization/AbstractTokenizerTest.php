<?php

namespace UniAlteri\Tests\States\LifeCycle\Tokenization;

use UniAlteri\States\LifeCycle\Event\EventInterface;
use UniAlteri\States\LifeCycle\Tokenization\TokenizerInterface;
use UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;

/**
 * Class AbstractTokenizerTest.
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
        /**
         * @var EventInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $instance->expects($this->any())->method('getObject')->willReturn(new Acme());
        $this->assertTrue(is_array($this->build()->getToken($instance)));
    }
}
