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

use UniAlteri\States\LifeCycle\Observing\ObservedFactoryInterface;

/**
 * Class AbstractObservedFactoryTest.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
abstract class AbstractObservedFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return ObservedFactoryInterface
     */
    abstract public function build();

    /**
     * @expectedException \TypeError
     */
    public function testCreateBadObserver()
    {
        $this->build()->create(new \stdClass(), $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface'));
    }

    /**
     * @expectedException \TypeError
     */
    public function testCreateBadInstance()
    {
        $this->build()->create($this->getMock('UniAlteri\States\LifeCycle\Observing\ObserverInterface'), new \stdClass());
    }

    public function testCreate()
    {
        $factory = $this->build();

        $this->assertInstanceOf(
            'UniAlteri\States\LifeCycle\Observing\ObservedInterface',
            $factory->create(
                $this->getMock('UniAlteri\States\LifeCycle\Observing\ObserverInterface'),
                $this->getMock('UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface')
            )
        );
    }
}
