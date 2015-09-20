<?php

namespace UniAlteri\Tests\States\LifeCycle\StatedClass;

use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;

/**
 * Class AbstractLifeCyclableTest
 * @package UniAlteri\Tests\States\LifeCycle\StatedClass
 */
abstract class AbstractLifeCyclableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return LifeCyclableInterface
     */
    abstract public function build();

    /**
     * @expectedException \TypeError
     */
    public function testRegisterObserverBadArg()
    {
        $this->build()->registerObserver(new \stdClass());
    }

    public function testRegisterObserver()
    {
        $observer = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObserverInterface');
        $instance = $this->build();
        $this->assertEquals(
            $instance,
            $instance->registerObserver($observer)
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testUnregisterObserverBadArg()
    {
        $this->build()->unregisterObserver(new \stdClass());
    }

    public function testUnregisterObserver()
    {
        $observer = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObserverInterface');
        $instance = $this->build();
        $this->assertEquals(
            $instance,
            $instance->unregisterObserver($observer)
        );
    }

    public function testNotifyObserved()
    {
        $instance = $this->build();
        $this->assertEquals(
            $instance,
            $instance->notifyObserved()
        );
    }
}