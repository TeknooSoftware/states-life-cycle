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

namespace Teknoo\Tests\States\LifeCycle\StatedClass;

use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\LifeCycle\StatedClass\LifeCyclableTrait;
use Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;

/**
 * Class LifeCycableTest.
 *
 * @covers Teknoo\States\LifeCycle\StatedClass\LifeCyclableTrait
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
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
        /**
         * @var ObservedInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $observed = $this->createMock(ObservedInterface::class);
        $observed->expects(self::once())->method('observeUpdate');

        $instance = $this->build();
        $instance->registerObserver($observed);

        self::assertEquals(
            $instance,
            $instance->notifyObserved()
        );
    }
}
