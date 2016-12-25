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

namespace Teknoo\Tests\States\LifeCycle\Observing;

use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\LifeCycle\Observing\ObserverInterface;
use Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface;
use Teknoo\States\LifeCycle\Trace\TraceInterface;
use Teknoo\Tests\States\LifeCycle\Support\Event;

/**
 * Class AbstractObservedTest.
 *
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
abstract class AbstractObservedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param mixed $instance
     * @param mixed $observer
     * @param mixed $trace
     * @param mixed $eventClassName
     *
     * @return ObservedInterface
     */
    abstract public function build($instance, $observer, $trace, $eventClassName);

    /**
     * @expectedException \TypeError
     */
    public function testConstructorBadInstance()
    {
        $this->build(
            new \stdClass(),
            $this->createMock(ObserverInterface::class),
            $this->createMock(TraceInterface::class),
            Event::class
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructorBadObserver()
    {
        $instance = $this->createMock(LifeCyclableInterface::class);
        $this->build(
            $instance,
            new \stdClass(),
            $this->createMock(TraceInterface::class),
            Event::class
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructorBadTrace()
    {
        $instance = $this->createMock(LifeCyclableInterface::class);
        self::assertInstanceOf(
            ObservedInterface::class,
            $this->build(
                $instance,
                $this->createMock(ObserverInterface::class),
                new \stdClass(),
                Event::class
            )
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConstructorMissingEvent()
    {
        $instance = $this->createMock(LifeCyclableInterface::class);
        self::assertInstanceOf(
            ObservedInterface::class,
            $this->build(
                $instance,
                $this->createMock(ObserverInterface::class),
                $this->createMock(TraceInterface::class),
                'Teknoo\States\LifeCycle\Trace\EntryMissed'
            )
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConstructorBadEvent()
    {
        $instance = $this->createMock(LifeCyclableInterface::class);
        self::assertInstanceOf(
            ObservedInterface::class,
            $this->build(
                $instance,
                $this->createMock(ObserverInterface::class),
                $this->createMock(TraceInterface::class),
                'Teknoo\States\LifeCycle\Trace\Entry'
            )
        );
    }

    public function testConstructor()
    {
        $instance = $this->createMock(LifeCyclableInterface::class);
        self::assertInstanceOf(
            ObservedInterface::class,
            $this->build(
                $instance,
                $this->createMock(ObserverInterface::class),
                $this->createMock(TraceInterface::class),
                Event::class
            )
        );
    }

    public function testGetObject()
    {
        $instance = $this->createMock(LifeCyclableInterface::class);
        self::assertEquals(
            $instance,
            $this->build(
                $instance,
                $this->createMock(ObserverInterface::class),
                $this->createMock(TraceInterface::class),
                Event::class
            )->getObject()
        );
    }

    public function testGetObserver()
    {
        $instance = $this->createMock(LifeCyclableInterface::class);
        $observer = $this->createMock(ObserverInterface::class);
        self::assertEquals(
            $observer,
            $this->build(
                $instance,
                $observer,
                $this->createMock(TraceInterface::class),
                Event::class
            )->getObserver()
        );
    }

    public function testGetStatedClassName()
    {
        $instance = $this->createMock('Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme');
        self::assertEquals(
            'Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme',
            $this->build(
                $instance,
                $this->createMock(ObserverInterface::class),
                $this->createMock(TraceInterface::class),
                Event::class
            )->getStatedClassName()
        );
    }

    public function testObserveUpdate()
    {
        $instance = $this->createMock(LifeCyclableInterface::class);
        $instance->expects(self::any())->method('listEnabledStates')->willReturn([]);
        $instance->expects(self::any())->method('listAvailableStates')->willReturn([]);
        self::assertInstanceOf(
            ObservedInterface::class,
            $this->build(
                $instance,
                $this->createMock(ObserverInterface::class),
                $this->createMock(TraceInterface::class),
                Event::class
            )->observeUpdate()
        );
    }

    public function testGetStateTrace()
    {
        $instance = $this->createMock(LifeCyclableInterface::class);
        self::assertInstanceOf(
            TraceInterface::class,
            $this->build(
                $instance,
                $this->createMock(ObserverInterface::class),
                $this->createMock(TraceInterface::class),
                Event::class
            )->getStateTrace()
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetLastEventException()
    {
        $instance = $this->createMock(LifeCyclableInterface::class);
        $this->build(
            $instance,
            $this->createMock(ObserverInterface::class),
            $this->createMock(TraceInterface::class),
            Event::class
        )->getLastEvent();
    }

    public function testGetLastEvent()
    {
        $instance = $this->createMock(LifeCyclableInterface::class);
        $instance->expects(self::any())->method('listEnabledStates')->willReturn([]);
        $instance->expects(self::any())->method('listAvailableStates')->willReturn([]);
        $observed = $this->build(
            $instance,
            $this->createMock(ObserverInterface::class),
            $this->createMock(TraceInterface::class),
            Event::class
        );
        $observed->observeUpdate();
        self::assertInstanceOf(
            EventInterface::class,
            $observed->getLastEvent()
        );
    }
}
