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
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\Tests\States\LifeCycle\Observing;

use UniAlteri\States\LifeCycle\Observing\Observed;
use UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;

/**
 * Class ObservedTest.
 *
 * @covers UniAlteri\States\LifeCycle\Observing\Observed
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
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
     *
     * @return Observed
     */
    public function build($instance, $observer)
    {
        return new Observed($instance, $observer);
    }

    public function testGetStatedClassName()
    {
        $this->assertEquals(
            'UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme',
            $this->build(new Acme(), $this->getMock('UniAlteri\States\LifeCycle\Observing\ObserverInterface'))->getStatedClassName()
        );
    }

    public function testObserveUpdateFirstEvent()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $instance->expects($this->any())->method('listEnabledStates')->willReturn(['state1', 'state3']);
        $instance->expects($this->any())->method('listAvailableStates')->willReturn(['state1', 'state2', 'state3']);

        $observer = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObserverInterface');

        $observed = $this->build($instance, $observer);

        $observer->expects($this->once())->method('dispatchNotification')->with($observed)->willReturnSelf();

        $trace = $observed->getStateTrace();
        $this->assertTrue($trace->isEmpty());

        $observed->observeUpdate();

        $this->assertFalse($trace->isEmpty());

        $entry = $trace->getFirstEntry();
        $this->assertEquals($observed, $entry->getObserved());
        $this->assertEquals(['state1', 'state3'], $entry->getEnabledState());
        $this->assertNull($entry->getNext());
        $this->assertNull($entry->getPrevious());
    }

    public function testObserveUpdateNewEvent()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface');
        $instance->expects($this->any())->method('listEnabledStates')->willReturnOnConsecutiveCalls(['state1', 'state3'], ['state1', 'state3'], ['state1'], ['state1'], ['state2'], ['state2']);
        $instance->expects($this->any())->method('listAvailableStates')->willReturn(['state1', 'state2', 'state3']);

        $observer = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObserverInterface');

        $observed = $this->build($instance, $observer);

        $observer->expects($this->exactly(3))->method('dispatchNotification')->with($observed)->willReturnSelf();

        $trace = $observed->getStateTrace();
        $this->assertTrue($trace->isEmpty());

        $observed->observeUpdate();

        $this->assertFalse($trace->isEmpty());

        $entry = $trace->getFirstEntry();
        $this->assertEquals($observed, $entry->getObserved());
        $this->assertEquals(['state1', 'state3'], $entry->getEnabledState());
        $this->assertNull($entry->getNext());
        $this->assertNull($entry->getPrevious());

        $observed->observeUpdate();

        $entry = $trace->getFirstEntry();
        $this->assertEquals($observed, $entry->getObserved());
        $this->assertEquals(['state1', 'state3'], $entry->getEnabledState());
        $this->assertNotEmpty($entry->getNext());
        $this->assertNull($entry->getPrevious());

        $nextEntry = $entry->getNext();
        $this->assertEquals($observed, $nextEntry->getObserved());
        $this->assertEquals(['state1'], $nextEntry->getEnabledState());
        $this->assertEquals($entry, $nextEntry->getPrevious());
        $this->assertNull($nextEntry->getNext());

        $observed->observeUpdate();

        $entry = $trace->getFirstEntry();
        $this->assertEquals($observed, $entry->getObserved());
        $this->assertEquals(['state1', 'state3'], $entry->getEnabledState());
        $this->assertNotEmpty($entry->getNext());
        $this->assertNull($entry->getPrevious());

        $nextEntry = $entry->getNext();
        $this->assertEquals($observed, $nextEntry->getObserved());
        $this->assertEquals(['state1'], $nextEntry->getEnabledState());
        $this->assertEquals($entry, $nextEntry->getPrevious());
        $this->assertNotNull($nextEntry->getNext());

        $nextEntry2 = $nextEntry->getNext();
        $this->assertEquals($observed, $nextEntry2->getObserved());
        $this->assertEquals(['state2'], $nextEntry2->getEnabledState());
        $this->assertEquals($nextEntry, $nextEntry2->getPrevious());
        $this->assertNull($nextEntry2->getNext());
    }
}
