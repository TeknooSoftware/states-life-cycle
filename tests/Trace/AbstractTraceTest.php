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
namespace Teknoo\Tests\States\LifeCycle\Trace;

use Teknoo\States\LifeCycle\Trace\TraceInterface;

/**
 * Class AbstractTraceTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
abstract class AbstractTraceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return TraceInterface
     */
    abstract public function build();

    public function testConstruct()
    {
        $this->build();
    }

    public function testGetTrace()
    {
        $this->assertInstanceOf(
            '\SplStack',
            $this->build()->getTrace()
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetFirstEntryEmpty()
    {
        $this->build()->getFirstEntry();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetLastEntryEmpty()
    {
        $this->build()->getLastEntry();
    }

    public function testGetFirstEntry()
    {
        $observed = $this->getMock('Teknoo\States\LifeCycle\Observing\ObservedInterface');
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Trace\EntryInterface',
            $this->build()->addEntry($observed, [])->getFirstEntry()
        );
    }

    public function testGetLastEntry()
    {
        $observed = $this->getMock('Teknoo\States\LifeCycle\Observing\ObservedInterface');
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Trace\EntryInterface',
            $this->build()->addEntry($observed, [])->getLastEntry()
        );
    }

    public function testAddEntry()
    {
        $observed = $this->getMock('Teknoo\States\LifeCycle\Observing\ObservedInterface');
        $service = $this->build();
        $this->assertEquals(
            $service,
            $service->addEntry($observed, [])
        );
    }

    public function testIsEmpty()
    {
        $observed = $this->getMock('Teknoo\States\LifeCycle\Observing\ObservedInterface');
        $service = $this->build();
        $this->assertTrue($service->isEmpty());
        $service->addEntry($observed, []);
        $this->assertFalse($service->isEmpty());
    }

    public function testAddEntries()
    {
        $trace = $this->build();
        $this->assertTrue($trace->isEmpty());

        $observed = $this->getMock('Teknoo\States\LifeCycle\Observing\ObservedInterface');
        $trace->addEntry($observed, ['state1', 'state3']);

        $this->assertFalse($trace->isEmpty());

        $entry = $trace->getFirstEntry();
        $this->assertEquals($observed, $entry->getObserved());
        $this->assertEquals(['state1', 'state3'], $entry->getEnabledState());
        $this->assertNull($entry->getNext());
        $this->assertNull($entry->getPrevious());

        $trace->addEntry($observed, ['state1']);

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

        $trace->addEntry($observed, ['state2']);

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
