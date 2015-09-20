<?php

namespace UniAlteri\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Event\EventInterface;
use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;

/***
 * Interface ScenarioInterface
 * @package UniAlteri\States\LifeCycle\LifeCycle
 */
interface ScenarioInterface
{
    /**
     * @return string[]
     */
    public function getEventsNamesList(): array;

    /**
     * @return string[]
     */
    public function listNeededIncomingStates(): array;

    /**
     * @return string[]
     */
    public function listNeededOutgoingStates(): array;

    /**
     * @return string[]
     */
    public function listNeededStates(): array;

    /**
     * @return string
     */
    public function getNeededStatedClass(): \string;

    /**
     * @return LifeCyclableInterface
     */
    public function getNeededStatedObject(): LifeCyclableInterface;

    /**
     * @param EventInterface $event
     * @return bool
     */
    public function isAllowedToRun(EventInterface $event): \bool;

    /**
     * @param EventInterface $event
     * @return mixed
     */
    public function __invoke(EventInterface $event);
}