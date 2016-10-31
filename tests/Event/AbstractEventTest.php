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

namespace Teknoo\Tests\States\LifeCycle\Event;

use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface;

/**
 * Class AbstractEventTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
abstract class AbstractEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $observed
     * @param $incomingState
     * @param $outGoingState
     *
     * @return EventInterface
     */
    abstract public function build($observed, $incomingState, $outGoingState);

    /**
     * @expectedException \TypeError
     */
    public function testConstructorBadObserver()
    {
        $this->build(new \stdClass(), [], []);
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructorBadIncomingState()
    {
        $observed = $this->createMock(ObservedInterface::class);
        $this->build($observed, '', []);
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructorBadOutgoingState()
    {
        $observed = $this->createMock(ObservedInterface::class);
        $this->build($observed, [], '');
    }

    public function testConstructor()
    {
        $observed = $this->createMock(ObservedInterface::class);
        self::assertInstanceOf(
            EventInterface::class,
            $this->build($observed, [], [])
        );
    }

    public function testGetObserved()
    {
        $observed = $this->createMock(ObservedInterface::class);
        self::assertEquals(
            $observed,
            $this->build($observed, [], [])->getObserved()
        );
    }

    public function testGetObject()
    {
        $instance = $this->createMock(LifeCyclableInterface::class);
        $observed = $this->createMock(ObservedInterface::class);
        $observed->expects(self::once())->method('getObject')->willReturn($instance);
        self::assertEquals(
            $instance,
            $this->build($observed, [], [])->getObject()
        );
    }

    public function testGetEnabledStates()
    {
        $instance = $this->createMock(LifeCyclableInterface::class);
        $instance->expects(self::once())->method('listEnabledStates')->willReturn(['foo', 'bar']);
        $observed = $this->createMock(ObservedInterface::class);
        $observed->expects(self::once())->method('getObject')->willReturn($instance);
        self::assertEquals(
            ['foo', 'bar'],
            $this->build($observed, [], [])->getEnabledStates()
        );
    }

    public function testGetIncomingStates()
    {
        $observed = $this->createMock(ObservedInterface::class);
        self::assertEquals(
            ['bar', 'foo'],
            $this->build($observed, ['bar', 'foo'], [])->getIncomingStates()
        );
    }

    public function testGetOutgoingStates()
    {
        $observed = $this->createMock(ObservedInterface::class);
        self::assertEquals(
            ['foo', 'bar'],
            $this->build($observed, [], ['foo', 'bar'])->getOutgoingStates()
        );
    }
}
