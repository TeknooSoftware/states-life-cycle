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
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\Tests\States\LifeCycle\StatedClass;

use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableTrait;
use UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;

/**
 * Class LifeCycableTest.
 *
 * @covers UniAlteri\States\LifeCycle\StatedClass\LifeCyclableTrait
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class LifeCycableTest extends AbstractLifeCyclableTest
{
    /**
     * @return LifeCyclableTrait
     */
    public function build()
    {
        return new Acme();
    }

    public function testNotifyObservedFilled()
    {
        /*
         * @var ObservedInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface');
        $observed->expects($this->once())->method('observeUpdate');

        $instance = $this->build();
        $instance->registerObserver($observed);

        $this->assertEquals(
            $instance,
            $instance->notifyObserved()
        );
    }
}
