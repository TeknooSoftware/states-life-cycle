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

use Teknoo\States\LifeCycle\Observing\Observed;
use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\LifeCycle\Observing\ObserverInterface;
use Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface;
use Teknoo\States\LifeCycle\Trace\TraceInterface;
use Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;
use Teknoo\Tests\States\LifeCycle\Support\Event;

/**
 * Class ObservedTest.
 *
 * @covers \Teknoo\States\LifeCycle\Observing\Observed
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
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
        self::assertEquals(
            'Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme',
            $this->build(
                new Acme(),
                $this->createMock(ObserverInterface::class),
                $this->createMock(TraceInterface::class),
                Event::class
            )->getStatedClassName()
        );
    }

    public function testObserveUpdateFirstEvent()
    {
        $instance = $this->createMock(LifeCyclableInterface::class);
        $instance->expects(self::any())->method('listEnabledStates')->willReturn(['state1', 'state3']);
        $instance->expects(self::any())->method('listAvailableStates')->willReturn(['state1', 'state2', 'state3']);

        $observer = $this->createMock(ObserverInterface::class);

        $trace = $this->createMock(TraceInterface::class);
        $trace->expects(self::once())->method('addEntry')
            ->with(
                $this->callback(function ($arg) {
                    return $arg instanceof ObservedInterface;
                }),
                ['state1', 'state3']
            );

        $observed = $this->build(
            $instance,
            $observer,
            $trace,
            Event::class
        );

        $observer->expects(self::once())->method('dispatchNotification')->with($observed)->willReturnSelf();

        $observed->observeUpdate();
    }

    public function testObserveUpdateNewEvent()
    {
        $instance = $this->createMock(LifeCyclableInterface::class);
        $instance->expects(self::any())->method('listEnabledStates')->willReturnOnConsecutiveCalls(['state1', 'state3'], ['state1', 'state3'], ['state1'], ['state1'], ['state2'], ['state2']);
        $instance->expects(self::any())->method('listAvailableStates')->willReturn(['state1', 'state2', 'state3']);

        $observer = $this->createMock(ObserverInterface::class);

        $trace = $this->createMock(TraceInterface::class);
        $observed = $this->build(
            $instance,
            $observer,
            $trace,
            Event::class
        );

        $trace->expects(self::exactly(3))->method('addEntry')
            ->withConsecutive(
                [$this->callback(function ($arg) {
                    return $arg instanceof ObservedInterface;
                }), ['state1', 'state3']],
                [$this->callback(function ($arg) {
                    return $arg instanceof ObservedInterface;
                }), ['state1']],
                [$this->callback(function ($arg) {
                    return $arg instanceof ObservedInterface;
                }), ['state2']]
            );

        $observer->expects(self::exactly(3))->method('dispatchNotification')->with($observed)->willReturnSelf();

        $observed->observeUpdate();
        $observed->observeUpdate();
        $observed->observeUpdate();
    }
}
