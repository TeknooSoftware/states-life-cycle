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

namespace Teknoo\States\LifeCycle\StatedClass\Automated;

use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\AssertionInterface;
use Teknoo\States\Proxy\ProxyInterface;

/**
 * Interface AutomatedInterface
 * Interface to implement automated stated class to enable or disable states according to validation rules defined
 * in your class
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
interface AutomatedInterface extends ProxyInterface
{
    /**
     * Method called by the stated class instance itself to perform states changes according its validations rules
     * @return AutomatedInterface
     */
    public function updateStates(): AutomatedInterface;

    /**
     * To get all validations rules needed by instances
     * @return AssertionInterface[]
     */
    public function getStatesAssertions(): array;
}
