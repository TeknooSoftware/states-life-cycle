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
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\Tests\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Scenario\ScenarioInterface;

/**
 * Class AbstractScenarioTest.
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
abstract class AbstractScenarioTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return ScenarioInterface
     */
    abstract public function build();

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
            'UniAlteri\States\LifeCycle\Observing\ObservedInterface',
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
