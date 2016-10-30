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
 * to richarddeloge@gmail.com so we can send you a copy immediately.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
namespace Teknoo\Tests\States\LifeCycle\Scenario;

use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\LifeCycle\Scenario\Scenario;
use Teknoo\States\LifeCycle\Scenario\ScenarioBuilder;
use Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;

/**
 * Class ScenarioTest.
 *
 * @covers \Teknoo\States\LifeCycle\Scenario\Scenario
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
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
            $this->scenarioBuilder = $this->createMock(ScenarioBuilder::class, [], [], '', false);
        }

        return $this->scenarioBuilder;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ObservedInterface
     */
    protected function getObservedInterfaceMock()
    {
        if (!$this->observed instanceof ObservedInterface) {
            $this->observed = $this->createMock(ObservedInterface::class);
        }

        return $this->observed;
    }

    /**
     * @param bool $noPopulateMock
     *
     * @return Scenario
     */
    public function build(bool $noPopulateMock = false)
    {
        $builder = $this->getScenarioBuilderMock();
        if (false === $noPopulateMock) {
            $builder->expects(self::any())->method('getEventNamesList')->willReturn(['event1', 'event2']);
            $builder->expects(self::any())->method('getNeededIncomingStatesList')->willReturn(['foo', 'bar']);
            $builder->expects(self::any())->method('getNeededOutgoingStatesList')->willReturn(['outstate']);
            $builder->expects(self::any())->method('getNeededStatesList')->willReturn(['foo', 'bar', 'state']);
            $builder->expects(self::any())->method('getStatedClassName')->willReturn('fooBarName');
            $observed = $this->getObservedInterfaceMock();
            $builder->expects(self::any())->method('getObserved')->willReturn($observed);
            $builder->expects(self::any())->method('getCallable')->willReturn(function () {
            });
        }

        $scenario = new Scenario($builder);
        $scenario->configure($builder);

        return $scenario;
    }

    public function testGetEventsNamesListValue()
    {
        self::assertEquals(['event1', 'event2'], $this->build()->getEventsNamesList());
    }

    public function testListNeededIncomingStatesValue()
    {
        self::assertEquals(['foo', 'bar'], $this->build()->listNeededIncomingStates());
    }

    public function testListNeededOutgoingStatesValue()
    {
        self::assertEquals(['outstate'], $this->build()->listNeededOutgoingStates());
    }

    public function testListNeededStatesValue()
    {
        self::assertEquals(['foo', 'bar', 'state'], $this->build()->listNeededStates());
    }

    public function testGetNeededStatedClassValue()
    {
        self::assertEquals('fooBarName', $this->build()->getNeededStatedClass());
    }

    public function testGetNeededStatedObjectValue()
    {
        self::assertEquals(
            $this->getObservedInterfaceMock(),
            $this->build()->getNeededStatedObject()
        );
    }

    public function testIsAllowedToRunCheckNeededIncomingStatesTrue()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects(self::any())->method('getObserved')->willReturn(null);
        $builder->expects(self::any())->method('getStatedClassName')->willReturn('');
        $builder->expects(self::any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededIncomingStatesList')->willReturn(['state1', 'state2']);

        $service = $this->build(true);
        $eventMock = $this->createMock(EventInterface::class);
        $eventMock->expects(self::once())->method('getIncomingStates')->willReturn(['state1', 'state2', 'state3']);
        self::assertTrue($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededIncomingStatesFalse()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects(self::any())->method('getObserved')->willReturn(null);
        $builder->expects(self::any())->method('getStatedClassName')->willReturn('');
        $builder->expects(self::any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededIncomingStatesList')->willReturn(['state1', 'state2', 'state3']);

        $service = $this->build(true);
        $eventMock = $this->createMock(EventInterface::class);
        $eventMock->expects(self::once())->method('getIncomingStates')->willReturn(['state1', 'state2']);
        self::assertFalse($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededOutgoingStatesTrue()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects(self::any())->method('getObserved')->willReturn(null);
        $builder->expects(self::any())->method('getStatedClassName')->willReturn('');
        $builder->expects(self::any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededOutgoingStatesList')->willReturn(['state1', 'state2']);
        $builder->expects(self::any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->createMock(EventInterface::class);
        $eventMock->expects(self::once())->method('getOutgoingStates')->willReturn(['state1', 'state2', 'state3']);
        self::assertTrue($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededOutgoingStatesFalse()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects(self::any())->method('getObserved')->willReturn(null);
        $builder->expects(self::any())->method('getStatedClassName')->willReturn('');
        $builder->expects(self::any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededOutgoingStatesList')->willReturn(['state1', 'state2', 'state3']);
        $builder->expects(self::any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->createMock(EventInterface::class);
        $eventMock->expects(self::once())->method('getOutgoingStates')->willReturn(['state1', 'state2']);
        self::assertFalse($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededStatesTrue()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects(self::any())->method('getObserved')->willReturn(null);
        $builder->expects(self::any())->method('getStatedClassName')->willReturn('');
        $builder->expects(self::any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededStatesList')->willReturn(['state1', 'state2']);
        $builder->expects(self::any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->createMock(EventInterface::class);
        $acme = $this->createMock('Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme');
        $acme->expects(self::any())->method('listEnabledStates')->willReturn(['state1', 'state2', 'state3']);
        $eventMock->expects(self::once())->method('getObject')->willReturn($acme);
        self::assertTrue($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededStatesFalse()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects(self::any())->method('getObserved')->willReturn(null);
        $builder->expects(self::any())->method('getStatedClassName')->willReturn('');
        $builder->expects(self::any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededStatesList')->willReturn(['state1', 'state2']);
        $builder->expects(self::any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->createMock(EventInterface::class);
        $acme = $this->createMock('Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme');
        $acme->expects(self::any())->method('listEnabledStates')->willReturn(['state3', 'state1']);
        $eventMock->expects(self::once())->method('getObject')->willReturn($acme);
        self::assertFalse($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckForbiddenStatesTrue()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects(self::any())->method('getObserved')->willReturn(null);
        $builder->expects(self::any())->method('getStatedClassName')->willReturn('');
        $builder->expects(self::any())->method('getForbiddenStatesList')->willReturn(['state1', 'state2']);
        $builder->expects(self::any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->createMock(EventInterface::class);
        $acme = $this->createMock('Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme');
        $acme->expects(self::any())->method('listEnabledStates')->willReturn(['state3', 'state4']);
        $eventMock->expects(self::once())->method('getObject')->willReturn($acme);
        self::assertTrue($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckForbiddenStatesFalse()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects(self::any())->method('getObserved')->willReturn(null);
        $builder->expects(self::any())->method('getStatedClassName')->willReturn('');
        $builder->expects(self::any())->method('getForbiddenStatesList')->willReturn(['state1', 'state3']);
        $builder->expects(self::any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->createMock(EventInterface::class);
        $acme = $this->createMock('Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme');
        $acme->expects(self::any())->method('listEnabledStates')->willReturn(['state3', 'state4']);
        $eventMock->expects(self::once())->method('getObject')->willReturn($acme);
        self::assertFalse($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededStatedClassTrue()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects(self::any())->method('getObserved')->willReturn(null);
        $builder->expects(self::any())->method('getStatedClassName')->willReturn('fooBar');
        $builder->expects(self::any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->createMock(EventInterface::class);
        $observed = $this->getObservedInterfaceMock();
        $observed->expects(self::once())->method('getStatedClassName')->willReturn('fooBar');
        $eventMock->expects(self::once())->method('getObserved')->willReturn($observed);
        self::assertTrue($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededStatedClassFalse()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects(self::any())->method('getObserved')->willReturn(null);
        $builder->expects(self::any())->method('getStatedClassName')->willReturn('fooBar');
        $builder->expects(self::any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->createMock(EventInterface::class);
        $observed = $this->getObservedInterfaceMock();
        $observed->expects(self::once())->method('getStatedClassName')->willReturn('fooBar2');
        $eventMock->expects(self::once())->method('getObserved')->willReturn($observed);
        self::assertFalse($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededStatedObjectTrue()
    {
        $Acme = new Acme();

        $builder = $this->getScenarioBuilderMock();
        $builder->expects(self::any())->method('getObserved')->willReturn($Acme);
        $builder->expects(self::any())->method('getStatedClassName')->willReturn('');
        $builder->expects(self::any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->createMock(EventInterface::class);
        $eventMock->expects(self::once())->method('getObject')->willReturn($Acme);
        self::assertTrue($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunCheckNeededStatedObjectFalse()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects(self::any())->method('getObserved')->willReturn(new Acme());
        $builder->expects(self::any())->method('getStatedClassName')->willReturn('');
        $builder->expects(self::any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->createMock(EventInterface::class);
        $eventMock->expects(self::once())->method('getObject')->willReturn(new Acme());
        self::assertFalse($service->isAllowedToRun($eventMock));
    }

    public function testIsAllowedToRunmpty()
    {
        $builder = $this->getScenarioBuilderMock();
        $builder->expects(self::any())->method('getObserved')->willReturn(null);
        $builder->expects(self::any())->method('getStatedClassName')->willReturn('');
        $builder->expects(self::any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededIncomingStatesList')->willReturn([]);

        $service = $this->build(true);
        $eventMock = $this->createMock(EventInterface::class);
        self::assertTrue($service->isAllowedToRun($eventMock));
    }

    public function testInvokeTrue()
    {
        $called = false;
        $builder = $this->getScenarioBuilderMock();
        $builder->expects(self::any())->method('getObserved')->willReturn(null);
        $builder->expects(self::any())->method('getStatedClassName')->willReturn('fooBar');
        $builder->expects(self::any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededIncomingStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getCallable')->willReturn(function () use (&$called) {$called = true;});

        $service = $this->build(true);
        $eventMock = $this->createMock(EventInterface::class);
        $observed = $this->getObservedInterfaceMock();
        $observed->expects(self::once())->method('getStatedClassName')->willReturn('fooBar');
        $eventMock->expects(self::once())->method('getObserved')->willReturn($observed);

        $called = false;
        $service($eventMock);
        self::assertTrue($called);
    }

    public function testInvokeFalse()
    {
        $called = false;
        $builder = $this->getScenarioBuilderMock();
        $builder->expects(self::any())->method('getObserved')->willReturn(null);
        $builder->expects(self::any())->method('getStatedClassName')->willReturn('fooBar');
        $builder->expects(self::any())->method('getForbiddenStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededOutgoingStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getNeededIncomingStatesList')->willReturn([]);
        $builder->expects(self::any())->method('getCallable')->willReturn(function () use (&$called) {$called = true;});

        $service = $this->build(true);
        $eventMock = $this->createMock(EventInterface::class);
        $observed = $this->getObservedInterfaceMock();
        $observed->expects(self::once())->method('getStatedClassName')->willReturn('fooBar2');
        $eventMock->expects(self::once())->method('getObserved')->willReturn($observed);

        $called = false;
        $service($eventMock);
        self::assertFalse($called);
    }
}
