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