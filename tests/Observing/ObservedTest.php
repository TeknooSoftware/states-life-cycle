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
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\Tests\States\LifeCycle\Observing;

use UniAlteri\States\LifeCycle\Observing\Observed;
use UniAlteri\States\LifeCycle\Observing\ObservedInterface;
use UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;

/**
 * Class ObservedTest.
 *
 * @covers UniAlteri\States\LifeCycle\Observing\Observed
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class ObservedTest extends AbstractObservedTest
{
    /**
     * @param mixed $instance
     * @param mixed $observer
     * @param mixed $trace
     * @param mixed $eventClassName
     *
     * @return Observed
     */
    public function build($instance, $observer, $trace, $eventClassName)
    {
        return new Observed($instance, $observer, $trace, $eventClassName);
    }

    public function testGetStatedClassName()
    {
        $this->assertEquals(
            'UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme',
            $this->build(
                new Acme(),
                $this->getMock('UniAlteri\States\LifeCycle\Observing\ObserverInterface'),
                $this->getMock('UniAlteri\States\LifeCycle\Trace\TraceInterface'),
                'UniAlteri\States\LifeCycle\Event\Event'
            )->getStatedClassName()
        );
    }

    public function testObserveUpdateFirstEvent()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $instance->expects($this->any())->method('listEnabledStates')->willReturn(['state1', 'state3']);
        $instance->expects($this->any())->method('listAvailableStates')->willReturn(['state1', 'state2', 'state3']);

        $observer = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObserverInterface');

        $trace = $this->getMock('UniAlteri\States\LifeCycle\Trace\TraceInterface');
        $trace->expects($this->once())->method('addEntry')
            ->with(
                $this->callback(function ($arg) {return $arg instanceof ObservedInterface; }),
                ['state1', 'state3']
            );

        $observed = $this->build(
            $instance,
            $observer,
            $trace,
            'UniAlteri\States\LifeCycle\Event\Event'
        );

        $observer->expects($this->once())->method('dispatchNotification')->with($observed)->willReturnSelf();

        $observed->observeUpdate();
    }

    public function testObserveUpdateNewEvent()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $instance->expects($this->any())->method('listEnabledStates')->willReturnOnConsecutiveCalls(['state1', 'state3'], ['state1', 'state3'], ['state1'], ['state1'], ['state2'], ['state2']);
        $instance->expects($this->any())->method('listAvailableStates')->willReturn(['state1', 'state2', 'state3']);

        $observer = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObserverInterface');

        $trace = $this->getMock('UniAlteri\States\LifeCycle\Trace\TraceInterface');
        $observed = $this->build(
            $instance,
            $observer,
            $trace,
            'UniAlteri\States\LifeCycle\Event\Event'
        );

        $trace->expects($this->exactly(3))->method('addEntry')
            ->withConsecutive(
                [$this->callback(function ($arg) {return $arg instanceof ObservedInterface; }), ['state1', 'state3']],
                [$this->callback(function ($arg) {return $arg instanceof ObservedInterface; }), ['state1']],
                [$this->callback(function ($arg) {return $arg instanceof ObservedInterface; }), ['state2']]
            );

        $observer->expects($this->exactly(3))->method('dispatchNotification')->with($observed)->willReturnSelf();

        $observed->observeUpdate();
        $observed->observeUpdate();
        $observed->observeUpdate();
    }
}
