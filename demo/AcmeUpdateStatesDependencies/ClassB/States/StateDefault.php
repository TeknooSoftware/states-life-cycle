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

namespace demo\AcmeUpdateStatesDependencies\ClassB\States;

use Teknoo\States\State\AbstractState;
use demo\AcmeUpdateStatesDependencies\ClassB\ClassB;

/**
 * State StateDefault
 * State for the stated class ClassB.
 *
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 * @mixin ClassB
 */
class StateDefault extends AbstractState
{
    public function switchToState2()
    {
        /*
         * @return ClassB
         */
        return function () {
            $this->switchState(State2::class)
                ->notifyObserved();

            return $this;
        };
    }

    public function switchToState3()
    {
        /*
         * @return ClassB
         */
        return function () {
            $this->switchState(State3::class)
                ->notifyObserved();

            return $this;
        };
    }
}
