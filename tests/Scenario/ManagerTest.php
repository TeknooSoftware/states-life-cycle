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

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use UniAlteri\States\LifeCycle\Scenario\Manager;

/**
 * Class ManagerTest.
 *
 * @covers UniAlteri\States\LifeCycle\Scenario\Manager
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class ManagerTest extends AbstractManagerTest
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|EventDispatcherInterface
     */
    public function getEventDispatcherInterfaceMock()
    {
        if (!$this->dispatcher instanceof EventDispatcherInterface) {
            $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        }

        return $this->dispatcher;
    }

    /**
     * @return Manager
     */
    public function build()
    {
        return new Manager($this->getEventDispatcherInterfaceMock());
    }

    public function testRegisterScenarioMultiple()
    {
        /*
         * @var ScenarioInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $scenario = $this->getMock('UniAlteri\States\LifeCycle\Scenario\ScenarioInterface');
        $scenario->expects($this->any())->method('getEventsNamesList')->willReturn(['event1', 'event2', 'event3']);

        $this->getEventDispatcherInterfaceMock()
            ->expects($this->exactly(3))
            ->method('addListener')
            ->withConsecutive(
                ['event1', $scenario],
                ['event2', $scenario],
                ['event3', $scenario]
            );

        $service = $this->build();
        $this->assertEquals($service, $service->registerScenario($scenario)->registerScenario($scenario));
    }

    public function testUnregisterScenarioMultiple()
    {
        /*
         * @var ScenarioInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $scenario = $this->getMock('UniAlteri\States\LifeCycle\Scenario\ScenarioInterface');
        $scenario->expects($this->any())->method('getEventsNamesList')->willReturn(['event1', 'event2', 'event3']);
        $service = $this->build();

        $this->getEventDispatcherInterfaceMock()
            ->expects($this->exactly(3))
            ->method('removeListener')
            ->withConsecutive(
                ['event1', $scenario],
                ['event2', $scenario],
                ['event3', $scenario]
            );

        $service->registerScenario($scenario);
        $this->assertEquals($service, $service->unregisterScenario($scenario)->unregisterScenario($scenario));
    }
}
