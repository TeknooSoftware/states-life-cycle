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
namespace Teknoo\Tests\States\LifeCycle\Observing;

use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\Event\EventDispatcherBridgeInterface;
use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\LifeCycle\Observing\ObserverInterface;
use Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface;
use Teknoo\States\LifeCycle\Tokenization\TokenizerInterface;

/**
 * Class AbstractObserverTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
abstract class AbstractObserverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return ObserverInterface
     */
    abstract public function build();

    /**
     * @expectedException \TypeError
     */
    public function testSetTokenizerBadArgument()
    {
        $this->build()->setTokenizer(new \stdClass());
    }

    public function testGetSetTokenizer()
    {
        /*
         * @var TokenizerInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $tokenizer = $this->createMock(TokenizerInterface::class);
        $service = $this->build();
        self::assertEquals($service, $service->setTokenizer($tokenizer));
        self::assertEquals($tokenizer, $service->getTokenizer());
    }

    /**
     * @expectedException \TypeError
     */
    public function testAddEventDispatcherBadArgument()
    {
        $this->build()->addEventDispatcher(new \stdClass());
    }

    public function testGetAddEventDispatcher()
    {
        /*
         * @var EventDispatcherInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $dispatcher = $this->createMock(EventDispatcherBridgeInterface::class);
        $service = $this->build();
        self::assertEquals($service, $service->addEventDispatcher($dispatcher));
    }

    /**
     * @expectedException \TypeError
     */
    public function testRemoveEventDispatcherBadArgument()
    {
        $this->build()->removeEventDispatcher(new \stdClass());
    }

    public function testRemoveEventDispatcher()
    {
        /*
         * @var EventDispatcherInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $dispatcher = $this->createMock(EventDispatcherBridgeInterface::class);
        $service = $this->build();
        self::assertEquals($service, $service->removeEventDispatcher($dispatcher));
        self::assertEquals($service, $service->addEventDispatcher($dispatcher));
        self::assertEquals($service, $service->removeEventDispatcher($dispatcher));
    }

    public function testListEventDispatcher()
    {
        $service = $this->build();
        self::assertTrue(is_array($service->listEventDispatcher()));
        self::assertEmpty($service->listEventDispatcher());

        /*
         * @var EventDispatcherInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $dispatcher = $this->createMock(EventDispatcherBridgeInterface::class);
        $service->addEventDispatcher($dispatcher)->addEventDispatcher($dispatcher);
        self::assertEquals(1, count($service->listEventDispatcher()));

        /*
         * @var EventDispatcherInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $dispatcher2 = $this->createMock(EventDispatcherBridgeInterface::class);
        $service->addEventDispatcher($dispatcher2);
        self::assertEquals(2, count($service->listEventDispatcher()));
    }

    /**
     * @expectedException \TypeError
     */
    public function testAttachObjectBadArgument()
    {
        $this->build()->attachObject(new \stdClass());
    }

    public function testGetAttachObject()
    {
        /*
         * @var LifeCyclableInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->createMock(LifeCyclableInterface::class);
        $instance->expects(self::once())->method('registerObserver');
        $service = $this->build();
        self::assertInstanceOf(
            ObservedInterface::class,
            $service->attachObject($instance)
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testDetachObjectBadArgument()
    {
        $this->build()->detachObject(new \stdClass());
    }

    public function testDetachObject()
    {
        /*
         * @var LifeCyclableInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->createMock(LifeCyclableInterface::class);
        $instance->expects(self::once())->method('unregisterObserver');
        $service = $this->build();
        self::assertEquals($service, $service->detachObject($instance));
        self::assertInstanceOf(
            ObservedInterface::class,
            $service->attachObject($instance)
        );
        self::assertEquals($service, $service->detachObject($instance));
    }

    public function testListObserved()
    {
        $service = $this->build();
        self::assertTrue(is_array($service->listObserved()));
        self::assertEmpty($service->listObserved());

        /*
         * @var LifeCyclableInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->createMock(LifeCyclableInterface::class);
        $service->attachObject($instance);
        $service->attachObject($instance);
        self::assertEquals(1, count($service->listObserved()));
        /*
         * @var LifeCyclableInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance2 = $this->createMock(LifeCyclableInterface::class);
        $service->attachObject($instance2);
        self::assertEquals(2, count($service->listObserved()));
    }

    public function testDispatchNotification()
    {
        /***
         * @var EventInterface|\PHPUnit_Framework_MockObject_MockObject $instance
         */
        $event = $this->createMock(EventInterface::class);
        /*
         * @var ObservedInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->createMock(ObservedInterface::class);
        $instance->expects(self::any())->method('getLastEvent')->willReturn($event);
        $service = $this->build();
        /*
         * @var TokenizerInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $tokenizer = $this->createMock(TokenizerInterface::class);
        $service->setTokenizer($tokenizer);
        self::assertEquals($service, $service->dispatchNotification($instance));
    }
}
