<?php

namespace UniAlteri\Tests\States\LifeCycle\Event;

use UniAlteri\States\LifeCycle\Event\DispatcherInterface;

/**
 * Class AbstractDispatcherTest
 * @package UniAlteri\Tests\States\LifeCycle\Event
 *
 * @covers UniAlteri\States\LifeCycle\Event\DispatcherInterface
 */
abstract class AbstractDispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return DispatcherInterface
     */
    abstract public function build();

    /**
     * @expectedException \TypeError
     */
    public function testNotifyBadArgument()
    {
        $this->build()->notify(new \stdClass());
    }

    public function testNotifyReturn()
    {
        $event = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface', [], [], '', false);
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Event\DispatcherInterface',
            $this->build()->notify($event)
        );
    }
}