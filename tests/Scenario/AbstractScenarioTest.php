<?php

namespace UniAlteri\Tests\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Scenario\ScenarioInterface;

/**
 * Class AbstractScenarioTest
 * @package UniAlteri\Tests\States\LifeCycle\Scenario
 */
abstract class AbstractScenarioTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return ScenarioInterface
     */
    abstract public function build();

    public function testGetObserved()
    {
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Observing\ObservedInterface',
            $this->build()->getObserved()
        );
    }

    public function testGetEventsNamesList()
    {
        $this->assertTrue(is_array($this->build()->getEventsNamesList()));
    }

    public function testListNeededIncomingStates()
    {
        $this->assertTrue(is_array($this->build()->listNeededIncomingStates()));
    }

    public function testListNeededOutgoingStates()
    {
        $this->assertTrue(is_array($this->build()->listNeededOutgoingStates()));
    }

    public function testListNeededStates()
    {
        $this->assertTrue(is_array($this->build()->listNeededStates()));
    }

    public function testGetNeededStatedClass()
    {
        $this->assertTrue(is_string($this->build()->getNeededStatedClass()));
    }

    public function testGetNeededStatedObject()
    {
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface',
            $this->build()->getNeededStatedObject()
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testIsAllowedToRunBadArg()
    {
        $this->build()->isAllowedToRun(new \stdClass());
    }

    public function testIsAllowedToRun()
    {
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $this->assertTrue(is_bool($this->build()->isAllowedToRun($eventMock)));
    }

    /**
     * @expectedException \TypeError
     */
    public function testInvokeBadArg()
    {
        $this->build()->__invoke(new \stdClass());
    }

    public function testInvoke()
    {
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $this->build()->__invoke($eventMock);
    }
}