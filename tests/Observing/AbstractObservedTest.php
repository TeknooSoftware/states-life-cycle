<?php

namespace UniAlteri\Tests\States\LifeCycle\Observing;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;

/**
 * Class AbstractObservedTest
 * @package UniAlteri\States\LifeCycle\Observing
 */
abstract class AbstractObservedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param mixed $instance
     * @param mixed $observer
     * @return ObservedInterface
     */
    abstract public function build($instance, $observer);

    /**
     * @expectedException \TypeError
     */
    public function testConstructorBadInstance()
    {
        $this->build(
            new \stdClass(),
            $this->getMock('UniAlteri\Tests\States\LifeCycle\Observing\ObserverInterface')
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructorBadObserver()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $this->build(
            $instance,
            new \stdClass()
        );
    }

    public function testConstructor()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Observing\ObservedInterface',
            $this->build($instance, $this->getMock('UniAlteri\Tests\States\LifeCycle\Observing\ObserverInterface'))
        );
    }

    public function testGetObject()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $this->assertEquals(
            $instance,
            $this->build($instance)->getObject()
        );
    }

    public function testGetStatedClassName()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $this->assertEquals(
            get_class($instance),
            $this->build($instance)->getStatedClassName()
        );
    }

    public function testObserveUpdate()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Observing\ObservedInterface',
            $this->build($instance)->observeUpdate()
        );
    }

    public function testGetStateTrace()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Trace\TraceInterface',
            $this->build($instance)->getStateTrace()
        );
    }

    public function testGetLastEvent()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Event\EventInterface',
            $this->build($instance)->getLastEvent()
        );
    }
}