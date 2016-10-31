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

namespace Teknoo\Tests\States\LifeCycle\Trace;

use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\LifeCycle\Trace\EntryInterface;
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
        self::assertInstanceOf(
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
        $observed = $this->createMock(ObservedInterface::class);
        self::assertInstanceOf(
            EntryInterface::class,
            $this->build()->addEntry($observed, [])->getFirstEntry()
        );
    }

    public function testGetLastEntry()
    {
        $observed = $this->createMock(ObservedInterface::class);
        self::assertInstanceOf(
            EntryInterface::class,
            $this->build()->addEntry($observed, [])->getLastEntry()
        );
    }

    public function testAddEntry()
    {
        $observed = $this->createMock(ObservedInterface::class);
        $service = $this->build();
        self::assertEquals(
            $service,
            $service->addEntry($observed, [])
        );
    }

    public function testIsEmpty()
    {
        $observed = $this->createMock(ObservedInterface::class);
        $service = $this->build();
        self::assertTrue($service->isEmpty());
        $service->addEntry($observed, []);
        self::assertFalse($service->isEmpty());
    }

    public function testAddEntries()
    {
        $trace = $this->build();
        self::assertTrue($trace->isEmpty());

        $observed = $this->createMock(ObservedInterface::class);
        $trace->addEntry($observed, ['state1', 'state3']);

        self::assertFalse($trace->isEmpty());

        $entry = $trace->getFirstEntry();
        self::assertEquals($observed, $entry->getObserved());
        self::assertEquals(['state1', 'state3'], $entry->getEnabledState());
        self::assertNull($entry->getNext());
        self::assertNull($entry->getPrevious());

        $trace->addEntry($observed, ['state1']);

        $entry = $trace->getFirstEntry();
        self::assertEquals($observed, $entry->getObserved());
        self::assertEquals(['state1', 'state3'], $entry->getEnabledState());
        self::assertNotEmpty($entry->getNext());
        self::assertNull($entry->getPrevious());

        $nextEntry = $entry->getNext();
        self::assertEquals($observed, $nextEntry->getObserved());
        self::assertEquals(['state1'], $nextEntry->getEnabledState());
        self::assertEquals($entry, $nextEntry->getPrevious());
        self::assertNull($nextEntry->getNext());

        $trace->addEntry($observed, ['state2']);

        $entry = $trace->getFirstEntry();
        self::assertEquals($observed, $entry->getObserved());
        self::assertEquals(['state1', 'state3'], $entry->getEnabledState());
        self::assertNotEmpty($entry->getNext());
        self::assertNull($entry->getPrevious());

        $nextEntry = $entry->getNext();
        self::assertEquals($observed, $nextEntry->getObserved());
        self::assertEquals(['state1'], $nextEntry->getEnabledState());
        self::assertEquals($entry, $nextEntry->getPrevious());
        self::assertNotNull($nextEntry->getNext());

        $nextEntry2 = $nextEntry->getNext();
        self::assertEquals($observed, $nextEntry2->getObserved());
        self::assertEquals(['state2'], $nextEntry2->getEnabledState());
        self::assertEquals($nextEntry, $nextEntry2->getPrevious());
        self::assertNull($nextEntry2->getNext());
    }
}
