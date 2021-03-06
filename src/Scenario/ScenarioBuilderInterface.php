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

namespace Teknoo\States\LifeCycle\Scenario;

use Teknoo\States\LifeCycle\Observing\ObservedInterface;

/***
 * Interface ScenarioBuilderInterface
 * Interface to create scenario builder to allow developper to create scenarii about stated class instances.
 * A scenario can accept several conditions : each condition must be validated to execute the scenario.
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
interface ScenarioBuilderInterface
{
    /**
     * To execute the scenario when an event is dispatched.
     *
     * @param string $eventName
     *
     * @return ScenarioBuilderInterface
     */
    public function when(string $eventName): ScenarioBuilderInterface;

    /**
     * To execute the scenario when an instance of this stated class is updated.
     *
     * @param string $statedClassName
     *
     * @return ScenarioBuilderInterface
     */
    public function towardStatedClass(string $statedClassName): ScenarioBuilderInterface;

    /**
     * To execute the scenario when a stated class instance is updated.
     *
     * @param ObservedInterface $observed
     *
     * @return ScenarioBuilderInterface
     */
    public function towardObserved(ObservedInterface $observed): ScenarioBuilderInterface;

    /**
     * To execute the scenario only if the stated class instance is not the this defined state.
     *
     * @param string $stateName
     *
     * @return ScenarioBuilderInterface
     */
    public function ifNotInState(string $stateName): ScenarioBuilderInterface;

    /**
     * To execute the scenario only if the stated class instance is in the this defined state.
     *
     * @param string $stateName
     *
     * @return ScenarioBuilderInterface
     */
    public function ifInState(string $stateName): ScenarioBuilderInterface;

    /**
     * To execute the scenario only if the stated class instance is incoming in the this defined state.
     *
     * @param string $stateName
     *
     * @return ScenarioBuilderInterface
     */
    public function onIncomingState(string $stateName): ScenarioBuilderInterface;

    /**
     * To execute the scenario only if the stated class instance is outgoing in the this defined state.
     *
     * @param string $stateName
     *
     * @return ScenarioBuilderInterface
     */
    public function onOutgoingState(string $stateName): ScenarioBuilderInterface;

    /**
     * To execute the callable (function, object callback or closure) if the scenario can be executed.
     *
     * @param callable $callable
     *
     * @return ScenarioBuilderInterface
     */
    public function run(callable $callable): ScenarioBuilderInterface;

    /**
     * To generate the scenario object used to check events and run it.
     *
     * @param ScenarioInterface $scenario
     *
     * @return ScenarioInterface
     */
    public function build(ScenarioInterface $scenario): ScenarioInterface;
}
