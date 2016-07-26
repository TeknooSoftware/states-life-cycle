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
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
namespace Teknoo\Tests\States\LifeCycle\StatedClass;

use Teknoo\Tests\States\LifeCycle\StatedClass\Support\AutomatedLifeCyclableAcme\AutomatedLifeCyclableAcme;

/**
 * Class AutomatedLifeCyclableTraitTest.
 *
 * @covers Teknoo\States\LifeCycle\StatedClass\AutomatedLifeCyclableTrait
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
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
        $this->assertTrue(is_array($instance->getStatesAssertions()));

        foreach ($instance->getStatesAssertions() as $assertion) {
            $this->assertInstanceOf(
                'Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\AssertionInterface',
                $assertion
            );
        }
    }

    public function testUpdateStates()
    {
        $instance = $this->build();
        $observer = $this->createMock('Teknoo\States\LifeCycle\Observing\ObservedInterface');
        $observer->expects($this->exactly(5))->method('observeUpdate')->willReturnSelf();

        $instance->registerObserver($observer);

        $this->assertEquals([], $instance->listEnabledStates());

        $instance->setFoo('bar');
        $this->assertEquals([], $instance->listEnabledStates());
        $instance->updateStates();
        $this->assertEquals(['State1'], $instance->listEnabledStates());

        $instance->setFoo1('bar1')->setFoo2(123);
        $this->assertEquals(['State1'], $instance->listEnabledStates());
        $instance->updateStates();
        $this->assertEquals(['State1'], $instance->listEnabledStates());

        $instance->setFoo1('bar1')->setFoo2(null);
        $this->assertEquals(['State1'], $instance->listEnabledStates());
        $instance->updateStates();
        $this->assertEquals(['State1', 'State2'], $instance->listEnabledStates());

        $instance->setFoo('');
        $this->assertEquals(['State1', 'State2'], $instance->listEnabledStates());
        $instance->updateStates();
        $this->assertEquals(['State2'], $instance->listEnabledStates());

        $instance->setFoo1('');
        $this->assertEquals(['State2'], $instance->listEnabledStates());
        $instance->updateStates();
        $this->assertEquals([], $instance->listEnabledStates());
    }
}
