<?php

declare(strict_types=1);

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

namespace Teknoo\States\LifeCycle\StatedClass\Automated;

use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\AssertionInterface;

/**
 * Class AutomatedTrait
 * Trait to implement in proxy of your stated classes to add automated behaviors.
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 *
 * @mixin AutomatedInterface
 * @mixin \Teknoo\States\Proxy\ProxyInterface
 */
trait AutomatedTrait
{
    /**
     * To get all validations rules needed by instances.
     *
     * @return AssertionInterface[]
     */
    abstract protected function getStatesAssertions(): array;

    /**
     * @return \Generator|AssertionInterface[]
     */
    private function iterateAssertions()
    {
        foreach ($this->getStatesAssertions() as $assertion) {
            if (!$assertion instanceof AssertionInterface) {
                throw new \RuntimeException('Error, all assertions must implements AssertionInterface');
            }

            yield $assertion;
        }
    }

    /**
     * Method called by the stated class instance itself to perform states changes according its validations rules.
     *
     * @return AutomatedInterface
     */
    public function updateStates(): AutomatedInterface
    {
        $this->disableAllStates();
        foreach ($this->iterateAssertions() as $assertion) {
            $assertion->check($this);
        }

        return $this;
    }
}
