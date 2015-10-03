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

use UniAlteri\States\LifeCycle\Observing\ObservedFactory;

/**
 * Class ObservedFactoryTest.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class ObservedFactoryTest extends AbstractObservedFactoryTest
{
    /**
     * @return ObservedFactory
     */
    public function build()
    {
        return new ObservedFactory(
            'UniAlteri\States\LifeCycle\Observing\Observed',
            'UniAlteri\States\LifeCycle\Event\Event',
            'UniAlteri\States\LifeCycle\Trace\Trace'
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructInvalidObservedClass()
    {
        $factory = new ObservedFactory(
            new \stdClass(),
            'UniAlteri\States\LifeCycle\Event\Event',
            'UniAlteri\States\LifeCycle\Trace\Trace'
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructInvalidEventClass()
    {
        $factory = new ObservedFactory(
            'UniAlteri\States\LifeCycle\Observing\Observed',
            new \stdClass(),
            'UniAlteri\States\LifeCycle\Trace\Trace'
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructInvalidTraceClass()
    {
        $factory = new ObservedFactory(
            'UniAlteri\States\LifeCycle\Observing\Observed',
            'UniAlteri\States\LifeCycle\Event\Event',
            new \stdClass()
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConstructMissingObservedClass()
    {
        $factory = new ObservedFactory(
            'NonExist',
            'UniAlteri\States\LifeCycle\Event\Event',
            'UniAlteri\States\LifeCycle\Trace\Trace'
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConstructMissingTraceClass()
    {
        $factory = new ObservedFactory(
            'UniAlteri\States\LifeCycle\Observing\Observed',
            'UniAlteri\States\LifeCycle\Event\Event',
            'NonExist'
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConstructBadObservedClass()
    {
        $factory = new ObservedFactory(
            '\DateTime',
            'UniAlteri\States\LifeCycle\Event\Event',
            'UniAlteri\States\LifeCycle\Trace\Trace'
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConstructBadTraceClass()
    {
        $factory = new ObservedFactory(
            'UniAlteri\States\LifeCycle\Observing\Observed',
            'UniAlteri\States\LifeCycle\Event\Event',
            '\DateTime'
        );
    }
}
