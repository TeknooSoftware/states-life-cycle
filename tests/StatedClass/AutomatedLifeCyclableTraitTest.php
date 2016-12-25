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
use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\AssertionInterface;
use Teknoo\Tests\States\LifeCycle\StatedClass\Support\AutomatedLifeCyclableAcme\AutomatedLifeCyclableAcme;
use Teknoo\Tests\States\LifeCycle\StatedClass\Support\AutomatedLifeCyclableAcme\States\State1;
use Teknoo\Tests\States\LifeCycle\StatedClass\Support\AutomatedLifeCyclableAcme\States\State2;

/**
 * Class AutomatedLifeCyclableTraitTest.
 *
 * @covers \Teknoo\States\LifeCycle\StatedClass\AutomatedLifeCyclableTrait
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class AutomatedLifeCyclableTraitTest extends AbstractLifeCyclableTest
{
    /**
     * @return AutomatedLifeCyclableAcme
     */
    public function build()
    {
        return new AutomatedLifeCyclableAcme();
    }

    public function testGetStatesAssertions()
    {
        $instance = $this->build();
        self::assertTrue(is_array($instance->getStatesAssertions()));

        foreach ($instance->getStatesAssertions() as $assertion) {
            self::assertInstanceOf(
                AssertionInterface::class,
                $assertion
            );
        }
    }

    public function testUpdateStates()
    {
        $instance = $this->build();
        $observer = $this->createMock(ObservedInterface::class);
        $observer->expects(self::exactly(5))->method('observeUpdate')->willReturnSelf();

        $instance->registerObserver($observer);

        self::assertEquals([], $instance->listEnabledStates());

        $instance->setFoo('bar');
        self::assertEquals([], $instance->listEnabledStates());
        $instance->updateStates();
        self::assertEquals([State1::class], $instance->listEnabledStates());

        $instance->setFoo1('bar1')->setFoo2(123);
        self::assertEquals([State1::class], $instance->listEnabledStates());
        $instance->updateStates();
        self::assertEquals([State1::class], $instance->listEnabledStates());

        $instance->setFoo1('bar1')->setFoo2(null);
        self::assertEquals([State1::class], $instance->listEnabledStates());
        $instance->updateStates();
        self::assertEquals([State1::class, State2::class], $instance->listEnabledStates());

        $instance->setFoo('');
        self::assertEquals([State1::class, State2::class], $instance->listEnabledStates());
        $instance->updateStates();
        self::assertEquals([State2::class], $instance->listEnabledStates());

        $instance->setFoo1('');
        self::assertEquals([State2::class], $instance->listEnabledStates());
        $instance->updateStates();
        self::assertEquals([], $instance->listEnabledStates());
    }
}
