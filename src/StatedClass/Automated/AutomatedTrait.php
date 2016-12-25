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

namespace Teknoo\States\LifeCycle\StatedClass\Automated;

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
     * Get the list of all new states.
     *
     * @return string[]
     */
    private function getNewStateList(): array
    {
        $statesList = [];

        foreach ($this->getStatesAssertions() as $stateAssertion) {
            if ($stateAssertion->isValid($this)) {
                $statesList = \array_merge(
                    $statesList,
                    \array_flip($stateAssertion->getStatesList())
                );
            }
        }

        return \array_keys($statesList);
    }

    /**
     * To remove canonical states name in the list to avoid error.
     *
     * @param array $newStateList
     *
     * @return AutomatedInterface
     */
    private function filterStatesNames(array &$newStateList): AutomatedInterface
    {
        foreach ($newStateList as &$stateName) {
            $this->validateName($stateName);
        }

        return $this;
    }

    /**
     * To enable and disable states according validations rules.
     *
     * @param string[] $newStateList
     *
     * @return AutomatedInterface
     */
    private function switchToNewStates(array $newStateList): AutomatedInterface
    {
        $this->filterStatesNames($newStateList);

        $lastEnabledStates = $this->listEnabledStates();

        $outgoingStates = \array_diff($lastEnabledStates, $newStateList);
        foreach ($outgoingStates as $stateName) {
            //disable older states
            $this->disableState($stateName);
        }

        $incomingStates = \array_diff($newStateList, $lastEnabledStates);
        foreach ($incomingStates as $stateName) {
            //enable missing states
            $this->enableState($stateName);
        }

        return $this;
    }

    /**
     * Method called by the stated class instance itself to perform states changes according its validations rules.
     *
     * @return AutomatedInterface
     */
    public function updateStates(): AutomatedInterface
    {
        $this->switchToNewStates(
            $this->getNewStateList()
        );

        return $this;
    }

    /**
     * To get all validations rules needed by instances.
     *
     * @return \Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\AssertionInterface[]
     */
    abstract public function getStatesAssertions(): array;
}
