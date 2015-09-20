<?php

namespace UniAlteri\Tests\States\LifeCycle\Trace;

use UniAlteri\States\LifeCycle\Trace\EntityInterface;

/**
 * Class AbstractEntityTest
 * @package UniAlteri\Tests\States\LifeCycle\Trace
 */
abstract class AbstractEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $observedInterface
     * @param $enabledStatesList
     * @return EntityInterface
     */
    abstract public function build($observedInterface, $enabledStatesList);

    /**
     * @expectedException \TypeError
     */
    public function testConstructBadObserver()
    {
        $this->build(new \stdClass(), []);
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructBadState()
    {
        $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'), new \stdClass());
    }

    public function testConstruct()
    {
        $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'), []);
    }

    public function testGetObserved()
    {
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Observing\ObservedInterface',
            $this->build()->getObserved()
        );
    }

    public function testGetEnabledState()
    {
        $this->assertTrue(
            is_array($this->build()->getObserved())
        );
    }

    public function testGetPrevious()
    {
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Trace\EntityInterface',
            $this->build()->getPrevious()
        );
    }

    public function testGetNext()
    {
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Trace\EntityInterface',
            $this->build()->getNext()
        );
    }
}