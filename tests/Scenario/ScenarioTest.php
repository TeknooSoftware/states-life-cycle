<?php

/**
 * States.
 *
 * LICENSE
 *
 * This source file is subject to the MIT license and the version 3 of the GPL3
 * license that are bundled with this package in the folder licences
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@uni-alteri.com so we can send you a copy immediately.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\Tests\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;
use UniAlteri\States\LifeCycle\Scenario\Scenario;
use UniAlteri\States\LifeCycle\Scenario\ScenarioBuilder;
use UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;

/**
 * Class ScenarioTest.
 *
 * @covers UniAlteri\States\LifeCycle\Scenario\Scenario
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class ScenarioTest extends AbstractScenarioTest
{
    /**
     * @var ScenarioBuilder
     */
    protected $scenarioBuilder;

    /**
     * @var ObservedInterface
     */
    protected $observed;

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ScenarioBuilder
     */
    protected function getScenarioBuilderMock()
    {
        if (!$this->scenarioBuilder instanceof ScenarioBuilder) {
            $this->scenarioBuilder = $this->getMock('UniAlteri\States\LifeCycle\Scenario\ScenarioBuilder', [], [], '', false);
        }

        return $this->scenarioBuilder;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ObservedInterface
     */
    protected function getObservedInterfaceMock()
    {
        if (!$this->observed instanceof ObservedInterface) {
            $this->observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface');
        }

        return $this->observed;
    }

    /**
     * @param bool $noPopulateMock
     * @return Scenario
     */
    public function build(\bool $noPopulateMock=false)
    {
        $builder = $this->getScenarioBuilderMock();
        if (false === $noPopulateMock) {
            $builder->expects($this->any())->method('getEventNamesList')->willReturn(['event1', 'event2']);
            $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn(['foo', 'bar']);
            $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn(['outstate']);
            $builder->expects($this->any())->method('getNeededStatesList')->willReturn(['foo', 'bar', 'state']);
            $builder->expects($this->any())->method('getStatedClassName')->willReturn('fooBarName');
            $observed = $this->getObservedInterfaceMock();
            $builder->expects($this->any())->method('getObserved')->willReturn($observed);
            $builder->expects($this->any())->method('getCallable')->willReturn(function () {
            });
        }

        $scenario = new Scenario($builder);
        $builder->build($scenario);
        return $scenario;
    }

    public function testGetEventsNamesListValue()
    {
        $this->assertEquals(['event1', 'event2'], $this->build()->getEventsNamesList());
    }

    public function testListNeededIncomingStatesValue()
    {
        $this->assertEquals(['foo', 'bar'], $this->build()->listNeededIncomingStates());
    }

    public function testListNeededOutgoingStatesValue()
    {
        $this->assertEquals(['outstate'], $this->build()->listNeededOutgoingStates());
    }

    public function testListNeededStatesValue()
    {
        $this->assertEquals(['foo', 'bar', 'state'], $this->build()->listNeededStates());
    }

    public function testGetNeededStatedClassValue()
    {
        $this->assertEquals('fooBarName', $this->build()->getNeededStatedClass());
    }

    public function testGetNeededStatedObjectValue()
    {
        $this->assertEquals(
            $this->getObservedInterfaceMock(),
            $this->build()->getNeededStatedObject()
        );
    }

    public function testIsAllowedToRunCheckNeededIncomingStatesTrue()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects($this->any())->method('getObserved')->willReturn(null);
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('');
        $builder->expects($this->any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn(['state1', 'state2']);

        $service = $this->build(true);
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $eventMock->expects($this->once())->method('getIncomingStates')->willReturn(['state1', 'state2', 'state3']);
        $this->assertTrue($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededIncomingStatesFalse()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects($this->any())->method('getObserved')->willReturn(null);
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('');
        $builder->expects($this->any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn(['state1', 'state2', 'state3']);

        $service = $this->build(true);
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $eventMock->expects($this->once())->method('getIncomingStates')->willReturn(['state1', 'state2']);
        $this->assertFalse($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededOutgoingStatesTrue()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects($this->any())->method('getObserved')->willReturn(null);
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('');
        $builder->expects($this->any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn(['state1', 'state2']);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $eventMock->expects($this->once())->method('getOutgoingStates')->willReturn(['state1', 'state2', 'state3']);
        $this->assertTrue($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededOutgoingStatesFalse()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects($this->any())->method('getObserved')->willReturn(null);
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('');
        $builder->expects($this->any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn(['state1', 'state2', 'state3']);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $eventMock->expects($this->once())->method('getOutgoingStates')->willReturn(['state1', 'state2']);
        $this->assertFalse($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededStatesTrue()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects($this->any())->method('getObserved')->willReturn(null);
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('');
        $builder->expects($this->any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn(['state1', 'state2']);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $acme = $this->getMock('UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme');
        $acme->expects($this->any())->method('listEnabledStates')->willReturn(['state1', 'state2', 'state3']);
        $eventMock->expects($this->once())->method('getObject')->willReturn($acme);
        $this->assertTrue($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededStatesFalse()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects($this->any())->method('getObserved')->willReturn(null);
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('');
        $builder->expects($this->any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn(['state1', 'state2']);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $acme = $this->getMock('UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme');
        $acme->expects($this->any())->method('listEnabledStates')->willReturn(['state3', 'state1']);
        $eventMock->expects($this->once())->method('getObject')->willReturn($acme);
        $this->assertFalse($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckForbiddenStatesTrue()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects($this->any())->method('getObserved')->willReturn(null);
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('');
        $builder->expects($this->any())->method('getForbiddenStatesList')->willReturn(['state1', 'state2']);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $acme = $this->getMock('UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme');
        $acme->expects($this->any())->method('listEnabledStates')->willReturn(['state3', 'state4']);
        $eventMock->expects($this->once())->method('getObject')->willReturn($acme);
        $this->assertTrue($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckForbiddenStatesFalse()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects($this->any())->method('getObserved')->willReturn(null);
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('');
        $builder->expects($this->any())->method('getForbiddenStatesList')->willReturn(['state1', 'state3']);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $acme = $this->getMock('UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme');
        $acme->expects($this->any())->method('listEnabledStates')->willReturn(['state3', 'state4']);
        $eventMock->expects($this->once())->method('getObject')->willReturn($acme);
        $this->assertFalse($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededStatedClassTrue()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects($this->any())->method('getObserved')->willReturn(null);
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('fooBar');
        $builder->expects($this->any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $observed = $this->getObservedInterfaceMock();
        $observed->expects($this->once())->method('getStatedClassName')->willReturn('fooBar');
        $eventMock->expects($this->once())->method('getObserved')->willReturn($observed);
        $this->assertTrue($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededStatedClassFalse()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects($this->any())->method('getObserved')->willReturn(null);
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('fooBar');
        $builder->expects($this->any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $observed = $this->getObservedInterfaceMock();
        $observed->expects($this->once())->method('getStatedClassName')->willReturn('fooBar2');
        $eventMock->expects($this->once())->method('getObserved')->willReturn($observed);
        $this->assertFalse($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededStatedObjectTrue()
    {
        $Acme = new Acme();

        $builder = $this->getScenarioBuilderMock();
        $builder->expects($this->any())->method('getObserved')->willReturn($Acme);
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('');
        $builder->expects($this->any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $eventMock->expects($this->once())->method('getObject')->willReturn($Acme);
        $this->assertTrue($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededStatedObjectFalse()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects($this->any())->method('getObserved')->willReturn(new Acme());
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('');
        $builder->expects($this->any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $eventMock->expects($this->once())->method('getObject')->willReturn(new Acme());
        $this->assertFalse($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunmpty()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects($this->any())->method('getObserved')->willReturn(null);
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('');
        $builder->expects($this->any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $this->assertTrue($service->isAllowedToRun($eventMock));
    }

    public function testInvokeTrue()
    {
        $called = false;
        $builder = $this->getScenarioBuilderMock();
        $builder->expects($this->any())->method('getObserved')->willReturn(null);
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('fooBar');
        $builder->expects($this->any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getCallable')->willReturn(function() use (&$called) {$called=true;});

        $service = $this->build(true);
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $observed = $this->getObservedInterfaceMock();
        $observed->expects($this->once())->method('getStatedClassName')->willReturn('fooBar');
        $eventMock->expects($this->once())->method('getObserved')->willReturn($observed);

        $called = false;
        $service($eventMock);
        $this->assertTrue($called);
    }

    public function testInvokeFalse()
    {
        $called = false;
        $builder = $this->getScenarioBuilderMock();
        $builder->expects($this->any())->method('getObserved')->willReturn(null);
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('fooBar');
        $builder->expects($this->any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn([]);
        $builder->expects($this->any())->method('getCallable')->willReturn(function() use (&$called) {$called=true;});

        $service = $this->build(true);
        $eventMock = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $observed = $this->getObservedInterfaceMock();
        $observed->expects($this->once())->method('getStatedClassName')->willReturn('fooBar2');
        $eventMock->expects($this->once())->method('getObserved')->willReturn($observed);

        $called = false;
        $service($eventMock);
        $this->assertFalse($called);
    }
}
