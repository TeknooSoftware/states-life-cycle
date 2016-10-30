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

use Teknoo\States\LifeCycle\Observing\EventDispatcherBridgeInterface;
use Teknoo\States\LifeCycle\Scenario\Manager;
use Teknoo\States\LifeCycle\Scenario\ScenarioInterface;

/**
 * Class ManagerTest.
 *
 * @covers \Teknoo\States\LifeCycle\Scenario\Manager
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class ManagerTest extends AbstractManagerTest
{
    /**
     * @var EventDispatcherBridgeInterface
     */
    protected $dispatcher;

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|EventDispatcherBridgeInterface
     */
    public function getEventDispatcherBridgeInterfaceMock()
    {
        if (!$this->dispatcher instanceof EventDispatcherBridgeInterface) {
            $this->dispatcher = $this->createMock(EventDispatcherBridgeInterface::class);
        }

        return $this->dispatcher;
    }

    /**
     * @return Manager
     */
    public function build()
    {
        return new Manager($this->getEventDispatcherBridgeInterfaceMock());
    }

    public function testRegisterScenarioMultiple()
    {
        /*
         * @var ScenarioInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $scenario = $this->createMock(ScenarioInterface::class);
        $scenario->expects(self::any())->method('getEventsNamesList')->willReturn(['event1', 'event2', 'event3']);

        $this->getEventDispatcherBridgeInterfaceMock()
            ->expects(self::exactly(3))
            ->method('addListener')
            ->withConsecutive(
                ['event1', $scenario],
                ['event2', $scenario],
                ['event3', $scenario]
            );

        $service = $this->build();
        self::assertEquals($service, $service->registerScenario($scenario)->registerScenario($scenario));
    }

    public function testUnregisterScenarioMultiple()
    {
        /*
         * @var ScenarioInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $scenario = $this->createMock(ScenarioInterface::class);
        $scenario->expects(self::any())->method('getEventsNamesList')->willReturn(['event1', 'event2', 'event3']);
        $service = $this->build();

        $this->getEventDispatcherBridgeInterfaceMock()
            ->expects(self::exactly(3))
            ->method('removeListener')
            ->withConsecutive(
                ['event1', $scenario],
                ['event2', $scenario],
                ['event3', $scenario]
            );

        $service->registerScenario($scenario);
        self::assertEquals($service, $service->unregisterScenario($scenario)->unregisterScenario($scenario));
    }
}
