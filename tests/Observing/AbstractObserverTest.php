<?php

namespace UniAlteri\Tests\States\LifeCycle\Observing;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use UniAlteri\States\LifeCycle\Event\EventInterface;
use UniAlteri\States\LifeCycle\Observing\ObservedInterface;
use UniAlteri\States\LifeCycle\Observing\ObserverInterface;
use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;
use UniAlteri\States\LifeCycle\Tokenization\TokenizerInterface;

/**
 * Class AbstractObserverTest.
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
        /**
         * @var TokenizerInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $tokenizer = $this->getMock('UniAlteri\States\LifeCycle\Tokenization\TokenizerInterface');
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
        /**
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
        /**
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
        /**
         * @var LifeCyclableInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $service = $this->build();
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Observing\ObservedInterface',
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
        /**
         * @var LifeCyclableInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $service = $this->build();
        $this->assertEquals($service, $service->detachObject($instance));
    }

    public function testListObserved()
    {
        $service = $this->build();
        $this->assertTrue(is_array($service->listObserved()));
    }

    public function testDispatchNotification()
    {
        /*
         * @var EventInterface|\PHPUnit_Framework_MockObject_MockObject $instance
         */
        $event = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        /**
         * @var ObservedInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface');
        $instance->expects($this->any())->method('getLastEvent')->willReturn($event);
        $service = $this->build();
        /**
         * @var TokenizerInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $tokenizer = $this->getMock('UniAlteri\States\LifeCycle\Tokenization\TokenizerInterface');
        $service->setTokenizer($tokenizer);
        $this->assertEquals($service, $service->dispatchNotification($instance));
    }
}
