<?php

namespace UniAlteri\Tests\States\LifeCycle\Trace;

use UniAlteri\States\LifeCycle\Trace\TraceInterface;

/**
 * Class AbstractTraceTest
 * @package UniAlteri\Tests\States\LifeCycle\Trace
 */
abstract class AbstractTraceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $observedInterface
     * @return TraceInterface
     */
    abstract public function build($observedInterface);

    /**
     * @expectedException \TypeError
     */
    public function testConstructBadObserver()
    {
        $this->build(new \stdClass());
    }

    public function testConstruct()
    {
        $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'));
    }

    public function testGetObserved()
    {
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Observing\ObservedInterface',
            $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'))->getObserved()
        );
    }

    public function testGetTrace()
    {
        $this->assertInstanceOf(
            '\SplStack',
            $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'))->getTrace()
        );
    }

    public function testGetFirstEntry()
    {
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Trace\EntryInterface',
            $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'))->getFirstEntry()
        );
    }

    public function testGetLastEntry()
    {
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Trace\EntryInterface',
            $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'))->getLastEntry()
        );
    }

    public function testAddEntry()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\Trace\EntryInterface');
        $service = $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'));
        $this->assertEquals(
            $service,
            $service->addEntry($instance)
        );
    }
}