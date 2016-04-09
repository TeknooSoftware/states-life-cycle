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
namespace Teknoo\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassB\States;

use Teknoo\States\State\AbstractState;
use Teknoo\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassB\ClassB;

/**
 * State State2
 * State for the stated class ClassB.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class State2 extends AbstractState
{
    /**
     * @return ClassB
     */
    public function switchToState1()
    {
        $this->switchState('StateDefault')
            ->notifyObserved();

        return $this;
    }

    /**
     * @return ClassB
     */
    public function switchToState3()
    {
        $this->switchState('State3')
            ->notifyObserved();

        return $this;
    }
}
