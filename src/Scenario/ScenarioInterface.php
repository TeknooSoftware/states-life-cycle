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

use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\Observing\ObservedInterface;

/***
 * Interface ScenarioInterface
 * Interface to implement scenario class to allow developper to write interaction with a stated class and its instances
 * with others components of the application
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
interface ScenarioInterface
{
    /**
     * To configure the scenario from the builder.
     *
     * @param ScenarioBuilder $scenarioBuilder
     *
     * @return ScenarioInterface
     */
    public function configure(ScenarioBuilder $scenarioBuilder): ScenarioInterface;

    /**
     * To get all events name used by this scenario to register itself in dispatcher.
     *
     * @return string[]
     */
    public function getEventsNamesList(): array;

    /**
     * List all mandatory incoming states to execute this scenario.
     *
     * @return string[]
     */
    public function listNeededIncomingStates(): array;

    /**
     * List all mandatory outgoing states to execute this scenario.
     *
     * @return string[]
     */
    public function listNeededOutgoingStates(): array;

    /**
     * List all mandatory states to execute this scenario.
     *
     * @return string[]
     */
    public function listNeededStates(): array;

    /**
     * List all forbidden states to execute this scenario.
     *
     * @return string[]
     */
    public function listForbiddenStates(): array;

    /**
     * Get the stated class name listens/attempted by this scenario.
     *
     * @return string
     */
    public function getNeededStatedClass(): string;

    /**
     * Get the stated class instance listens/attempted by this scenario.
     *
     * @return ObservedInterface|null
     */
    public function getNeededStatedObject();

    /**
     * Called to check if the scenario can be executed (all constraints are validated).
     *
     * @param EventInterface $event
     *
     * @return bool
     */
    public function isAllowedToRun(EventInterface $event): bool;

    /**
     * To call the scenario, check constraints and execute this scenario if it's valid.
     *
     * @param EventInterface $event
     *
     * @return mixed
     */
    public function __invoke(EventInterface $event);
}
