<?php

namespace UniAlteri\Tests\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Scenario\Scenario;

/**
 * Class ScenarioTest.
 *
 * @covers UniAlteri\States\LifeCycle\Scenario\Scenario
 */
class ScenarioTest extends AbstractScenarioTest
{
    /**
     * @return Scenario
     */
    public function build()
    {
        $builder = $this->getMock('UniAlteri\States\LifeCycle\Scenario\ScenarioBuilder');
        $builder->expects($this->any())->method('getEventNamesList')->willReturn(['fooBar']);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn(['foo', 'bar']);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn(['outstate']);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn(['foo', 'bar', 'state']);
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('fooBarName');
        $observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface');
        $builder->expects($this->any())->method('getObserved')->willReturn($observed);
        $builder->expects($this->any())->method('getCallable')->willReturn(function () {});

        return new Scenario($builder);
    }
}
