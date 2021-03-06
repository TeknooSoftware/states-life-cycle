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

use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\LifeCycle\Scenario\ScenarioInterface;

/**
 * Class AbstractScenarioTest.
 *
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
abstract class AbstractScenarioTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return ScenarioInterface
     */
    abstract public function build();

    public function testGetEventsNamesList()
    {
        self::assertTrue(is_array($this->build()->getEventsNamesList()));
    }

    public function testListNeededIncomingStates()
    {
        self::assertTrue(is_array($this->build()->listNeededIncomingStates()));
    }

    public function testListNeededOutgoingStates()
    {
        self::assertTrue(is_array($this->build()->listNeededOutgoingStates()));
    }

    public function testListNeededStates()
    {
        self::assertTrue(is_array($this->build()->listNeededStates()));
    }

    public function testGetNeededStatedClass()
    {
        self::assertTrue(is_string($this->build()->getNeededStatedClass()));
    }

    public function testGetNeededStatedObject()
    {
        self::assertInstanceOf(
            ObservedInterface::class,
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
        $eventMock = $this->createMock(EventInterface::class);
        self::assertTrue(is_bool($this->build()->isAllowedToRun($eventMock)));
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
        $eventMock = $this->createMock(EventInterface::class);
        self::assertEmpty($this->build()->__invoke($eventMock));
    }
}
