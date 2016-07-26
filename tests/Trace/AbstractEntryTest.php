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

use Teknoo\States\LifeCycle\Trace\EntryInterface;

/**
 * Class AbstractEntityTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
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
        $this->build($this->createMock('Teknoo\States\LifeCycle\Observing\ObservedInterface'), new \stdClass());
    }

    public function testConstruct()
    {
        $this->build($this->createMock('Teknoo\States\LifeCycle\Observing\ObservedInterface'), []);
    }

    public function testGetObserved()
    {
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Observing\ObservedInterface',
            $this->build($this->createMock('Teknoo\States\LifeCycle\Observing\ObservedInterface'), [])->getObserved()
        );
    }

    public function testGetEnabledState()
    {
        $this->assertTrue(
            is_array($this->build($this->createMock('Teknoo\States\LifeCycle\Observing\ObservedInterface'), [])->getEnabledState())
        );
    }

    public function testGetPreviousNull()
    {
        $this->assertNull(
            $this->build($this->createMock('Teknoo\States\LifeCycle\Observing\ObservedInterface'), [])->getPrevious()
        );
    }

    public function testGetNextNull()
    {
        $this->assertNull(
            $this->build($this->createMock('Teknoo\States\LifeCycle\Observing\ObservedInterface'), [])->getNext()
        );
    }

    public function testGetPrevious()
    {
        $previous = $this->createMock('Teknoo\States\LifeCycle\Trace\EntryInterface');
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Trace\EntryInterface',
            $this->build($this->createMock('Teknoo\States\LifeCycle\Observing\ObservedInterface'), [], $previous)->getPrevious()
        );
    }

    public function testSetNext()
    {
        $next = $this->createMock('Teknoo\States\LifeCycle\Trace\EntryInterface');
        $service = $this->build($this->createMock('Teknoo\States\LifeCycle\Observing\ObservedInterface'), []);
        $this->assertEquals(
            $service,
            $service->setNext($next)
        );
    }

    public function testGetNext()
    {
        $next = $this->createMock('Teknoo\States\LifeCycle\Trace\EntryInterface');
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Trace\EntryInterface',
            $this->build($this->createMock('Teknoo\States\LifeCycle\Observing\ObservedInterface'), [])->setNext($next)->getNext()
        );
    }
}
