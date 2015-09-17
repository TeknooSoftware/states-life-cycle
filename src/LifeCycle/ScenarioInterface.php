<?php

namespace UniAlteri\States\LifeCycle\LifeCycle;

use UniAlteri\States\LifeCycle\Event\EventInterface;
use UniAlteri\States\LifeCycle\Listening\ListenerInterface;

/***
 * Interface ScenarioInterface
 * @package UniAlteri\States\LifeCycle\LifeCycle
 */
interface ScenarioInterface extends ListenerInterface
{
    /**
     * @return string
     */
    public function getToward(): \string;

    /**
     * @return string[]
     */
    public function getEventsNamesList(): array;

    /**
     * @param EventInterface $event
     * @return bool
     */
    public function isAccepted(EventInterface $event): \bool;

    /**
     * @param EventInterface $event
     * @return mixed
     */
    public function __invoke(EventInterface $event);
}