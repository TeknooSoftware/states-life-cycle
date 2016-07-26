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

use Teknoo\States\LifeCycle\Observing\ObservedFactory;

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
            'Teknoo\States\LifeCycle\Observing\Observed',
            'Teknoo\States\LifeCycle\Event\Event',
            'Teknoo\States\LifeCycle\Trace\Trace'
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructInvalidObservedClass()
    {
        new ObservedFactory(
            new \stdClass(),
            'Teknoo\States\LifeCycle\Event\Event',
            'Teknoo\States\LifeCycle\Trace\Trace'
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructInvalidEventClass()
    {
        new ObservedFactory(
            'Teknoo\States\LifeCycle\Observing\Observed',
            new \stdClass(),
            'Teknoo\States\LifeCycle\Trace\Trace'
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructInvalidTraceClass()
    {
        new ObservedFactory(
            'Teknoo\States\LifeCycle\Observing\Observed',
            'Teknoo\States\LifeCycle\Event\Event',
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
            'Teknoo\States\LifeCycle\Event\Event',
            'Teknoo\States\LifeCycle\Trace\Trace'
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConstructMissingTraceClass()
    {
        new ObservedFactory(
            'Teknoo\States\LifeCycle\Observing\Observed',
            'Teknoo\States\LifeCycle\Event\Event',
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
            'Teknoo\States\LifeCycle\Event\Event',
            'Teknoo\States\LifeCycle\Trace\Trace'
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConstructBadTraceClass()
    {
        new ObservedFactory(
            'Teknoo\States\LifeCycle\Observing\Observed',
            'Teknoo\States\LifeCycle\Event\Event',
            '\DateTime'
        );
    }
}
