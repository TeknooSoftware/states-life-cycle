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

namespace Teknoo\States\LifeCycle\StatedClass\Automated;

use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\AssertionInterface;

/**
 * Class AutomatedTrait
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 *
 * @method string[] listEnabledStates()
 * @method AutomatedInterface enableState(\string $stateName)
 * @method AutomatedInterface disableState(\string $stateName)
 */
trait AutomatedTrait
{
    /**
     * @return string[]
     */
    private function getNewStateList(): array
    {
        $statesList = [];

        foreach ($this->getStatesAssertions() as $stateAssertion) {
            if ($stateAssertion->isValid($this)) {
                $statesList = array_merge(
                    $statesList,
                    array_flip($stateAssertion->getStatesList())
                );
            }
        }

        return array_keys($statesList);
    }

    /**
     * @param string[] $newStateList
     * @return AutomatedInterface
     */
    private function switchToNewStates(array $newStateList): AutomatedInterface
    {
        $lastEnabledStates = $this->listEnabledStates();

        $incomingStates = array_diff($newStateList, $lastEnabledStates);
        foreach ($incomingStates as $stateName) {
            $this->enableState($stateName);
        }

        $outgoingStates = array_diff($lastEnabledStates, $newStateList);
        foreach ($outgoingStates as $stateName) {
            $this->disableState($stateName);
        }

        return $this;
    }

    /**
     * @return AutomatedInterface
     */
    public function updateStates(): AutomatedInterface
    {
        $this->switchToNewStates(
            $this->getNewStateList()
        );
    }

    /**
     * @return AssertionInterface[]
     */
    abstract public function getStatesAssertions(): array;
}