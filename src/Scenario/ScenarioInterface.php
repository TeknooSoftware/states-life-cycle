<?php

namespace UniAlteri\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Event\EventInterface;
use UniAlteri\States\LifeCycle\Observing\ObservedInterface;

/***
 * Interface ScenarioInterface
 * @package UniAlteri\States\LifeCycle\LifeCycle
 */
interface ScenarioInterface
{
    /**
     * @return ObservedInterface
     */
    public function getObserved(): ObservedInterface;

    /**
     * @return string[]
     */
    public function getEventsNamesList(): array;

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