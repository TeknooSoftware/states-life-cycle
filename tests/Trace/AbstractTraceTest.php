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

namespace UniAlteri\Tests\States\LifeCycle\Trace;

use UniAlteri\States\LifeCycle\Trace\TraceInterface;

/**
 * Class AbstractTraceTest.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
abstract class AbstractTraceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $observedInterface
     *
     * @return TraceInterface
     */
    abstract public function build($observedInterface);

    /**
     * @expectedException \TypeError
     */
    public function testConstructBadObserver()
    {
        $this->build(new \stdClass());
    }

    public function testConstruct()
    {
        $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'));
    }

    public function testGetObserved()
    {
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Observing\ObservedInterface',
            $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'))->getObserved()
        );
    }

    public function testGetTrace()
    {
        $this->assertInstanceOf(
            '\SplStack',
            $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'))->getTrace()
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetFirstEntryEmpty()
    {
        $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'))->getFirstEntry();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetLastEntryEmpty()
    {
        $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'))->getLastEntry();
    }

    public function testGetFirstEntry()
    {
        $entry = $this->getMock('UniAlteri\States\LifeCycle\Trace\EntryInterface');
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Trace\EntryInterface',
            $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'))->addEntry($entry)->getFirstEntry()
        );
    }

    public function testGetLastEntry()
    {
        $entry = $this->getMock('UniAlteri\States\LifeCycle\Trace\EntryInterface');
        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Trace\EntryInterface',
            $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'))->addEntry($entry)->getLastEntry()
        );
    }

    public function testAddEntry()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\Trace\EntryInterface');
        $service = $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'));
        $this->assertEquals(
            $service,
            $service->addEntry($instance)
        );
    }

    public function testIsEmpty()
    {
        $instance = $this->getMock('UniAlteri\States\LifeCycle\Trace\EntryInterface');
        $service = $this->build($this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface'));
        $this->assertTrue($service->isEmpty());
        $service->addEntry($instance);
        $this->assertFalse($service->isEmpty());
    }
}
