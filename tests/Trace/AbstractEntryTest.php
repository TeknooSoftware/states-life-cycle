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
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */

namespace Teknoo\Tests\States\LifeCycle\Trace;

use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\LifeCycle\Trace\EntryInterface;

/**
 * Class AbstractEntityTest.
 *
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
abstract class AbstractEntryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $observedInterface
     * @param $enabledStatesList
     * @param $previous
     *
     * @return EntryInterface
     */
    abstract public function build($observedInterface, $enabledStatesList, $previous = null);

    /**
     * @expectedException \TypeError
     */
    public function testConstructBadObserver()
    {
        $this->build(new \stdClass(), []);
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructBadState()
    {
        $this->build($this->createMock(ObservedInterface::class), new \stdClass());
    }

    public function testConstruct()
    {
        $this->build($this->createMock(ObservedInterface::class), []);
    }

    public function testGetObserved()
    {
        self::assertInstanceOf(
            ObservedInterface::class,
            $this->build($this->createMock(ObservedInterface::class), [])->getObserved()
        );
    }

    public function testGetEnabledState()
    {
        self::assertTrue(
            is_array($this->build($this->createMock(ObservedInterface::class), [])->getEnabledState())
        );
    }

    public function testGetPreviousNull()
    {
        self::assertNull(
            $this->build($this->createMock(ObservedInterface::class), [])->getPrevious()
        );
    }

    public function testGetNextNull()
    {
        self::assertNull(
            $this->build($this->createMock(ObservedInterface::class), [])->getNext()
        );
    }

    public function testGetPrevious()
    {
        $previous = $this->createMock(EntryInterface::class);
        self::assertInstanceOf(
            EntryInterface::class,
            $this->build($this->createMock(ObservedInterface::class), [], $previous)->getPrevious()
        );
    }

    public function testSetNext()
    {
        $next = $this->createMock(EntryInterface::class);
        $service = $this->build($this->createMock(ObservedInterface::class), []);
        self::assertEquals(
            $service,
            $service->setNext($next)
        );
    }

    public function testGetNext()
    {
        $next = $this->createMock(EntryInterface::class);
        self::assertInstanceOf(
            EntryInterface::class,
            $this->build($this->createMock(ObservedInterface::class), [])->setNext($next)->getNext()
        );
    }
}
