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
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */

namespace Teknoo\Tests\States\LifeCycle\Scenario;

use Teknoo\States\LifeCycle\Event\EventDispatcherBridgeInterface;
use Teknoo\States\LifeCycle\Scenario\ManagerInterface;
use Teknoo\States\LifeCycle\Scenario\ScenarioInterface;

/**
 * Class AbstractManagerTest.
 *
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
abstract class AbstractManagerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return ManagerInterface
     */
    abstract public function build();

    /**
     * @expectedException \TypeError
     */
    public function testSetDispatcherBadArg()
    {
        $this->build()->setDispatcher(new \stdClass());
    }

    public function testGetSetDispatcher()
    {
        /**
         * @var EventDispatcherBridgeInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->createMock(EventDispatcherBridgeInterface::class);
        $service = $this->build();
        self::assertEquals($service, $service->setDispatcher($instance));
        self::assertEquals($instance, $service->getDispatcher());
    }

    /**
     * @expectedException \TypeError
     */
    public function testRegisterScenarioBadArg()
    {
        $this->build()->registerScenario(new \stdClass());
    }

    public function testRegisterScenario()
    {
        /*
         * @var ScenarioInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $scenario = $this->createMock(ScenarioInterface::class);
        $service = $this->build();
        self::assertEquals($service, $service->registerScenario($scenario));
    }

    /**
     * @expectedException \TypeError
     */
    public function testUnregisterScenarioBadArg()
    {
        $this->build()->unregisterScenario(new \stdClass());
    }

    public function testUnregisterScenario()
    {
        /*
         * @var ScenarioInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $scenario = $this->createMock(ScenarioInterface::class);
        $service = $this->build();
        self::assertEquals($service, $service->unregisterScenario($scenario));
    }

    public function testListScenarii()
    {
        self::assertTrue(is_array($this->build()->listScenarii()));
    }
}
