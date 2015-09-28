<?php

namespace UniAlteri\Tests\States\LifeCycle\StatedClass;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;
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
        /**
         * @var ObservedInterface|\PHPUnit_Framework_MockObject_MockObject $observed
         */
        $observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface');
        $instance = $this->build();
        $this->assertEquals(
            $instance,
            $instance->registerObserver($observed)
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
        /**
         * @var ObservedInterface|\PHPUnit_Framework_MockObject_MockObject $observed
         */
        $observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface');
        $instance = $this->build();
        $this->assertEquals(
            $instance,
            $instance->unregisterObserver($observed)
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