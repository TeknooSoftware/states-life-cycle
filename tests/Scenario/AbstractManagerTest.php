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
use UniAlteri\States\LifeCycle\Scenario\ManagerInterface;
use UniAlteri\States\LifeCycle\Scenario\ScenarioInterface;

/**
 * Class AbstractManagerTest.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
abstract class AbstractManagerTest extends \PHPUnit_Framework_TestCase
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
         * @var EventDispatcherInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $service = $this->build();
        $this->assertEquals($service, $service->setDispatcher($instance));
        $this->assertEquals($instance, $service->getDispatcher());
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
        /**
         * @var ScenarioInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $scenario = $this->getMock('UniAlteri\States\LifeCycle\Scenario\ScenarioInterface');
        $service = $this->build();
        $this->assertEquals($service, $service->registerScenario($scenario));
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
        /**
         * @var ScenarioInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $scenario = $this->getMock('UniAlteri\States\LifeCycle\Scenario\ScenarioInterface');
        $service = $this->build();
        $this->assertEquals($service, $service->unregisterScenario($scenario));
    }

    public function testListScenarii()
    {
        $this->assertTrue(is_array($this->build()->listScenarii()));
    }
}
