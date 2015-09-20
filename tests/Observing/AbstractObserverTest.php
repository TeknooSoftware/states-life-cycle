<?php

namespace UniAlteri\Tests\States\LifeCycle\Observing;

use UniAlteri\States\LifeCycle\Observing\ObserverInterface;

/**
 * Class AbstractObserverTest
 * @package UniAlteri\States\LifeCycle\Observing
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
        $tokenizer = $this->getMock('UniAlteri\States\LifeCycle\Tokenization\TokenizerInterface', [], [], '', false);
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
        $dispatcher = $this->getMock('UniAlteri\States\LifeCycle\Event\DispatcherInterface', [], [], '', false);
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
        $dispatcher = $this->getMock('UniAlteri\States\LifeCycle\Event\DispatcherInterface', [], [], '', false);
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
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface', [], [], '', false);
        $service = $this->build();
        $this->assertEquals($service, $service->attachObject($instance));
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
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface', [], [], '', false);
        $service = $this->build();
        $this->assertEquals($service, $service->detachObject($instance));
    }

    public function testListObserved()
    {
        $service = $this->build();
        $this->assertTrue(is_array($service->listObserved()));
    }
}