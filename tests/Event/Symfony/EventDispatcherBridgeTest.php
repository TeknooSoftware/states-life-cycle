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

namespace Teknoo\Tests\States\LifeCycle\Event\Symfony;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Teknoo\States\LifeCycle\Event\Symfony\Event;
use Teknoo\States\LifeCycle\Event\Symfony\EventDispatcherBridge;
use Teknoo\States\LifeCycle\Event\EventDispatcherBridgeInterface;

/**
 * Test EventDispatcherBridgeTest
 * @covers \Teknoo\States\LifeCycle\Event\Symfony\EventDispatcherBridge
 */
class EventDispatcherBridgeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|EventDispatcherInterface
     */
    public function getEventDispatcherMock()
    {
        if (!$this->eventDispatcher instanceof EventDispatcherInterface) {
            $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        }

        return $this->eventDispatcher;
    }

    /**
     * @return EventDispatcherBridge
     */
    public function buildBridge(): EventDispatcherBridge
    {
        return new EventDispatcherBridge($this->getEventDispatcherMock());
    }

    /**
     * @expectedException \TypeError
     */
    public function testDispatchBadEvent()
    {
        $this->buildBridge()->dispatch('foo.bar', new \stdClass());
    }

    public function testDispatch()
    {
        $event = $this->createMock(Event::class);

        $this->getEventDispatcherMock()
            ->expects(self::once())
            ->method('dispatch')
            ->with('foo.bar', $event);

        self::assertInstanceOf(
            EventDispatcherBridgeInterface::class,
            $this->buildBridge()->dispatch('foo.bar', $event)
        );
    }

    public function testAddListener()
    {
        $this->getEventDispatcherMock()
            ->expects(self::once())
            ->method('addListener')
            ->with('foo.bar', ['strlen'], 123);

        self::assertInstanceOf(
            EventDispatcherBridgeInterface::class,
            $this->buildBridge()->addListener('foo.bar', ['strlen'], 123)
        );
    }

    public function testRemoveListener()
    {
        $this->getEventDispatcherMock()
            ->expects(self::once())
            ->method('removeListener')
            ->with('foo.bar', ['strlen']);

        self::assertInstanceOf(
            EventDispatcherBridgeInterface::class,
            $this->buildBridge()->removeListener('foo.bar', ['strlen'])
        );
    }
}