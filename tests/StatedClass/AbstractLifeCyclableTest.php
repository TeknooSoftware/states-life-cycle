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

namespace UniAlteri\Tests\States\LifeCycle\StatedClass;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;
use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;

/**
 * Class AbstractLifeCyclableTest.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
abstract class AbstractLifeCyclableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return LifeCyclableInterface
     */
    abstract public function build();

    /**
     * @expectedException \TypeError
     */
    public function testRegisterObserverBadArg()
    {
        $this->build()->registerObserver(new \stdClass());
    }

    public function testRegisterObserver()
    {
        /*
         * @var ObservedInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface');
        $instance = $this->build();
        $this->assertEquals(
            $instance,
            $instance->registerObserver($observed)
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testUnregisterObserverBadArg()
    {
        $this->build()->unregisterObserver(new \stdClass());
    }

    public function testUnregisterObserver()
    {
        /*
         * @var ObservedInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface');
        $instance = $this->build();
        $this->assertEquals(
            $instance,
            $instance->unregisterObserver($observed)
        );
    }

    public function testNotifyObserved()
    {
        $instance = $this->build();
        $this->assertEquals(
            $instance,
            $instance->notifyObserved()
        );
    }
}
