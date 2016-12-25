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

namespace demo\AcmeUpdateStatesDependencies\ClassA\States;

use Teknoo\States\State\AbstractState;
use demo\AcmeUpdateStatesDependencies\ClassA\ClassA;

/**
 * State State2
 * State for the stated class ClassA.
 *
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 * @mixin ClassA
 */
class State2 extends AbstractState
{
    public function enableState3()
    {
        /*
         * @return ClassA
         */
        return function () {
            $this->enableState(State3::class)
                ->notifyObserved();

            return $this;
        };
    }

    public function switchToStateDefault()
    {
        /*
         * @return ClassA
         */
        return function () {
            $this->switchState(StateDefault::class)
                ->notifyObserved();

            return $this;
        };
    }

    public function switchToState3()
    {
        /*
         * @return ClassA
         */
        return function () {
            $this->switchState(State3::class)
                ->notifyObserved();

            return $this;
        };
    }
}
