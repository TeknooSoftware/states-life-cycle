<?php

namespace UniAlteri\Tests\States\LifeCycle\Event;

use UniAlteri\States\LifeCycle\Event\EventInterface;

/**
 * Class AbstractEventTest
 * @package UniAlteri\Tests\States\LifeCycle\Event
 */
abstract class AbstractEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $observed
     * @param $incomingState
     * @param $outGoingState
     * @return EventInterface
     */
    abstract public function build($observed, $incomingState, $outGoingState);

    /**
     * @expectedException \TypeError
     */
    public function testConstructorBadObserver()
    {
        $this->build(new \stdClass(), [], []);
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructorBadIncomingState()
    {
        $observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\Observed', [], [], '', false);
        $this->build($observed, '', []);
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructorBadOutgoingState()
    {
        $observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\Observed', [], [], '', false);
        $this->build($observed, [], '');
    }

    public function testConstructor()
    {
        $observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\Observed', [], [], '', false);
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Event\EventInterface',
            $this->build($observed, [], [])
        );
    }

    public function testGetObserved()
    {
        $observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\Observed', [], [], '', false);
        $this->assertEquals(
            $observed,
            $this->build($observed, [], [])->getObserved()
        );
    }

    public function testGetObject()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface', [], [], '', false);
        $observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\Observed', [], [], '', false);
        $observed->expects($this->once())->method('getObject')->willReturn($instance);
        $this->assertEquals(
            $instance,
            $this->build($observed, [], [])->getObject()
        );
    }

    public function testGetEnabledStates()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface', [], [], '', false);
        $instance->expects($this->once())->method('listEnabledStates')->willReturn(['foo', 'bar']);
        $observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\Observed', [], [], '', false);
        $observed->expects($this->once())->method('getObject')->willReturn($instance);
        $this->assertEquals(
            ['foo', 'bar'],
            $this->build($observed, [], [])->getEnabledStates()
        );
    }

    public function testGetIncomingStates()
    {
        $observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\Observed', [], [], '', false);
        $this->assertEquals(
            ['foo', 'bar'],
            $this->build($observed, ['foo', 'bar'], [])->getIncomingStates()
        );
    }

    public function testGetOutgoingStates()
    {
        $observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\Observed', [], [], '', false);
        $this->assertEquals(
            ['foo', 'bar'],
            $this->build($observed, [], ['foo', 'bar'])->getOutgoingStates()
        );
    }
}