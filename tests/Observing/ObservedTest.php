<?php

namespace UniAlteri\Tests\States\LifeCycle\Observing;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;

/**
 * Class ObservedTest
 * @package UniAlteri\States\LifeCycle\Observing
 */
class ObservedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param mixed $instance
     * @return ObservedInterface
     */
    public function build($instance)
    {

    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructorBadArgument()
    {
        $this->build(new \stdClass());
    }

    public function testConstructor()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface', [], [], '', false);
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Observing\ObservedInterface',
            $this->build($instance)
        );
    }

    public function testGetObject()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface', [], [], '', false);
        $this->assertEquals(
            $instance,
            $this->build($instance)->getObject()
        );
    }

    public function testGetStatedClassName()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface', [], [], '', false);
        $this->assertEquals(
            get_class($instance),
            $this->build($instance)->getStatedClassName()
        );
    }

    public function testObserveUpdate()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface', [], [], '', false);
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Observing\ObservedInterface',
            $this->build($instance)->observeUpdate()
        );
    }

    public function testGetStateTrace()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface', [], [], '', false);
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Trace\TraceInterface',
            $this->build($instance)->getStateTrace()
        );
    }
}