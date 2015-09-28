<?php

namespace UniAlteri\Tests\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;
use UniAlteri\States\LifeCycle\Scenario\ScenarioBuilderInterface;

/**
 * Class AbstractScenarioBuilderTest
 * @package UniAlteri\Tests\States\LifeCycle\Scenario
 */
abstract class AbstractScenarioBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return ScenarioBuilderInterface
     */
    abstract public function build();

    /**
     * @expectedException \TypeError
     */
    public function testWhenBadArg()
    {
        $this->build()->when(new \stdClass());
    }

    public function testWhen()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->when('eventName'));
    }

    /**
     * @expectedException \TypeError
     */
    public function testTowardStatedClassBadArg()
    {
        $this->build()->towardStatedClass(new \stdClass());
    }

    public function testTowardStatedClass()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->towardStatedClass('my\Stated\CustomClass'));
    }

    /**
     * @expectedException \TypeError
     */
    public function testTowardObservedBadArg()
    {
        $this->build()->towardObserved(new \stdClass());
    }

    public function testTowardObserved()
    {
        /**
         * @var ObservedInterface|\PHPUnit_Framework_MockObject_MockObject $observed
         */
        $observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface');
        $service = $this->build();
        $this->assertEquals($service, $service->towardObserved($observed));
    }

    /**
     * @expectedException \TypeError
     */
    public function testIfInStateBadArg()
    {
        $this->build()->ifInState(new \stdClass());
    }

    public function testIfInState()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->ifInState('stateName'));
    }

    /**
     * @expectedException \TypeError
     */
    public function testOnIncomingStateBadArg()
    {
        $this->build()->onIncomingState(new \stdClass());
    }

    public function testOnIncomingState()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->onIncomingState('stateName'));
    }

    /**
     * @expectedException \TypeError
     */
    public function testOnOutgoingStateBadArg()
    {
        $this->build()->onOutgoingState(new \stdClass());
    }

    public function testOnOutgoingState()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->onOutgoingState('stateName'));
    }

    /**
     * @expectedException \TypeError
     */
    public function testRunBadArg()
    {
        $this->build()->run(new \stdClass());
    }

    public function testRun()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->run(function(){}));
    }

    public function testBuild()
    {
        /**
         * @var ScenarioInterface|\PHPUnit_Framework_MockObject_MockObject $observed
         */
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Scenario\ScenarioInterface',
            $this->build()->build()
        );
    }
}