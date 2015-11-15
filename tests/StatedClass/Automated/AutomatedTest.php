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
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace Teknoo\Tests\States\LifeCycle\StatedClass\Automated;

use Teknoo\Tests\States\LifeCycle\StatedClass\Support\AutomatedAcme\AutomatedAcme;

/**
 * Class AutomatedTest
 *
 * @covers Teknoo\States\LifeCycle\StatedClass\Automated\AutomatedTrait
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class AutomatedTest extends AbstractAutomatedTest
{
    /**
     * @return AutomatedAcme
     */
    public function buildInstance()
    {
        return new AutomatedAcme();
    }

    public function testUpdateStates()
    {
        $instance = $this->buildInstance();
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