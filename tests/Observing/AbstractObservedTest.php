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
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */

namespace Teknoo\Tests\States\LifeCycle\Observing;

use Teknoo\States\LifeCycle\Observing\ObservedInterface;

/**
 * Class AbstractObservedTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
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
            $this->getMock('Teknoo\Tests\States\LifeCycle\Observing\ObserverInterface'),
            $this->getMock('Teknoo\States\LifeCycle\Trace\TraceInterface'),
            'Teknoo\States\LifeCycle\Event\Event'
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructorBadObserver()
    {
        $instance = $this->getMock('Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $this->build(
            $instance,
            new \stdClass(),
            $this->getMock('Teknoo\States\LifeCycle\Trace\TraceInterface'),
            'Teknoo\States\LifeCycle\Event\Event'
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructorBadTrace()
    {
        $instance = $this->getMock('Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Observing\ObservedInterface',
            $this->build(
                $instance,
                $this->getMock('Teknoo\States\LifeCycle\Observing\ObserverInterface'),
                new \stdClass(),
                'Teknoo\States\LifeCycle\Event\Event'
            )
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConstructorBadEvent()
    {
        $instance = $this->getMock('Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Observing\ObservedInterface',
            $this->build(
                $instance,
                $this->getMock('Teknoo\States\LifeCycle\Observing\ObserverInterface'),
                $this->getMock('Teknoo\States\LifeCycle\Trace\TraceInterface'),
                'Teknoo\States\LifeCycle\Trace\Entry'
            )
        );
    }

    public function testConstructor()
    {
        $instance = $this->getMock('Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Observing\ObservedInterface',
            $this->build(
                $instance,
                $this->getMock('Teknoo\States\LifeCycle\Observing\ObserverInterface'),
                $this->getMock('Teknoo\States\LifeCycle\Trace\TraceInterface'),
                'Teknoo\States\LifeCycle\Event\Event'
            )
        );
    }

    public function testGetObject()
    {
        $instance = $this->getMock('Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $this->assertEquals(
            $instance,
            $this->build(
                $instance,
                $this->getMock('Teknoo\States\LifeCycle\Observing\ObserverInterface'),
                $this->getMock('Teknoo\States\LifeCycle\Trace\TraceInterface'),
                'Teknoo\States\LifeCycle\Event\Event'
            )->getObject()
        );
    }

    public function testGetObserver()
    {
        $instance = $this->getMock('Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $observer = $this->getMock('Teknoo\States\LifeCycle\Observing\ObserverInterface');
        $this->assertEquals(
            $observer,
            $this->build(
                $instance,
                $observer,
                $this->getMock('Teknoo\States\LifeCycle\Trace\TraceInterface'),
                'Teknoo\States\LifeCycle\Event\Event'
            )->getObserver()
        );
    }

    public function testGetStatedClassName()
    {
        $instance = $this->getMock('Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme');
        $this->assertEquals(
            'Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme',
            $this->build(
                $instance,
                $this->getMock('Teknoo\States\LifeCycle\Observing\ObserverInterface'),
                $this->getMock('Teknoo\States\LifeCycle\Trace\TraceInterface'),
                'Teknoo\States\LifeCycle\Event\Event'
            )->getStatedClassName()
        );
    }

    public function testObserveUpdate()
    {
        $instance = $this->getMock('Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $instance->expects($this->any())->method('listEnabledStates')->willReturn([]);
        $instance->expects($this->any())->method('listAvailableStates')->willReturn([]);
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Observing\ObservedInterface',
            $this->build(
                $instance,
                $this->getMock('Teknoo\States\LifeCycle\Observing\ObserverInterface'),
                $this->getMock('Teknoo\States\LifeCycle\Trace\TraceInterface'),
                'Teknoo\States\LifeCycle\Event\Event'
            )->observeUpdate()
        );
    }

    public function testGetStateTrace()
    {
        $instance = $this->getMock('Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Trace\TraceInterface',
            $this->build(
                $instance,
                $this->getMock('Teknoo\States\LifeCycle\Observing\ObserverInterface'),
                $this->getMock('Teknoo\States\LifeCycle\Trace\TraceInterface'),
                'Teknoo\States\LifeCycle\Event\Event'
            )->getStateTrace()
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetLastEventException()
    {
        $instance = $this->getMock('Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $this->build(
            $instance,
            $this->getMock('Teknoo\States\LifeCycle\Observing\ObserverInterface'),
            $this->getMock('Teknoo\States\LifeCycle\Trace\TraceInterface'),
            'Teknoo\States\LifeCycle\Event\Event'
        )->getLastEvent();
    }

    public function testGetLastEvent()
    {
        $instance = $this->getMock('Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $instance->expects($this->any())->method('listEnabledStates')->willReturn([]);
        $instance->expects($this->any())->method('listAvailableStates')->willReturn([]);
        $observed = $this->build(
            $instance,
            $this->getMock('Teknoo\States\LifeCycle\Observing\ObserverInterface'),
            $this->getMock('Teknoo\States\LifeCycle\Trace\TraceInterface'),
            'Teknoo\States\LifeCycle\Event\Event'
        );
        $observed->observeUpdate();
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Event\EventInterface',
            $observed->getLastEvent()
        );
    }
}
