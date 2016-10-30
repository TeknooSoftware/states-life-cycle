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
use Teknoo\States\LifeCycle\Observing\ObservedFactory;
use Teknoo\States\LifeCycle\Trace\Trace;
use Teknoo\Tests\States\LifeCycle\Support\Event;

/**
 * Class ObservedFactoryTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class ObservedFactoryTest extends AbstractObservedFactoryTest
{
    /**
     * @return ObservedFactory
     */
    public function build()
    {
        return new ObservedFactory(
            Observed::class,
            Event::class,
            Trace::class
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructInvalidObservedClass()
    {
        new ObservedFactory(
            new \stdClass(),
            Event::class,
            Trace::class
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructInvalidEventClass()
    {
        new ObservedFactory(
            Observed::class,
            new \stdClass(),
            Trace::class
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructInvalidTraceClass()
    {
        new ObservedFactory(
            Observed::class,
            Event::class,
            new \stdClass()
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConstructMissingObservedClass()
    {
        new ObservedFactory(
            'NonExist',
            Event::class,
            Trace::class
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConstructMissingTraceClass()
    {
        new ObservedFactory(
            Observed::class,
            Event::class,
            'NonExist'
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConstructBadObservedClass()
    {
        new ObservedFactory(
            '\DateTime',
            Event::class,
            Trace::class
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConstructBadTraceClass()
    {
        new ObservedFactory(
            Observed::class,
            Event::class,
            '\DateTime'
        );
    }
}
