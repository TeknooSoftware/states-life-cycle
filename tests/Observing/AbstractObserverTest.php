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
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace Teknoo\Tests\States\LifeCycle\Observing;

use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\Observing\ObserverInterface;

/**
 * Class AbstractObserverTest.
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
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
        $tokenizer = $this->getMock('Teknoo\States\LifeCycle\Tokenization\TokenizerInterface');
        $service = $this->build();
        $this->assertEquals($service, $service->setTokenizer($tokenizer));
        $this->assertEquals($tokenizer, $service->getTokenizer());
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
        $dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $service = $this->build();
        $this->assertEquals($service, $service->addEventDispatcher($dispatcher));
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
        $dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $service = $this->build();
        $this->assertEquals($service, $service->removeEventDispatcher($dispatcher));
    }

    public function testListEventDispatcher()
    {
        $service = $this->build();
        $this->assertTrue(is_array($service->listEventDispatcher()));
        $this->assertEmpty($service->listEventDispatcher());

        /*
         * @var EventDispatcherInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $service->addEventDispatcher($dispatcher)->addEventDispatcher($dispatcher);
        $this->assertEquals(1, count($service->listEventDispatcher()));

        /*
         * @var EventDispatcherInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $dispatcher2 = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $service->addEventDispatcher($dispatcher2);
        $this->assertEquals(2, count($service->listEventDispatcher()));
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
        $instance = $this->getMock('Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $service = $this->build();
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Observing\ObservedInterface',
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
        $instance = $this->getMock('Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $service = $this->build();
        $this->assertEquals($service, $service->detachObject($instance));
    }

    public function testListObserved()
    {
        $service = $this->build();
        $this->assertTrue(is_array($service->listObserved()));
        $this->assertEmpty($service->listObserved());

        /*
         * @var LifeCyclableInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->getMock('Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $service->attachObject($instance);
        $service->attachObject($instance);
        $this->assertEquals(1, count($service->listObserved()));
        /*
         * @var LifeCyclableInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance2 = $this->getMock('Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $service->attachObject($instance2);
        $this->assertEquals(2, count($service->listObserved()));
    }

    public function testDispatchNotification()
    {
        /***
         * @var EventInterface|\PHPUnit_Framework_MockObject_MockObject $instance
         */
        $event = $this->getMock('Teknoo\States\LifeCycle\Event\EventInterface');
        /*
         * @var ObservedInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->getMock('Teknoo\States\LifeCycle\Observing\ObservedInterface');
        $instance->expects($this->any())->method('getLastEvent')->willReturn($event);
        $service = $this->build();
        /*
         * @var TokenizerInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $tokenizer = $this->getMock('Teknoo\States\LifeCycle\Tokenization\TokenizerInterface');
        $service->setTokenizer($tokenizer);
        $this->assertEquals($service, $service->dispatchNotification($instance));
    }
}
