<?php

namespace UniAlteri\States\LifeCycle\LifeCycle;
use UniAlteri\States\LifeCycle\Event\EventInterface;

/***
 * Interface ScenarioInterface
 * @package UniAlteri\States\LifeCycle\LifeCycle
 */
interface ScenarioInterface
{
    /**
     * @param string $eventName
     * @return ScenarioInterface
     */
    public function when(\string $eventName): ScenarioInterface;

    /**
     * @param string $stateName
     * @return ScenarioInterface
     */
    public function incoming(\string $stateName): ScenarioInterface;

    /**
     * @param string $stateName
     * @return ScenarioInterface
     */
    public function outgoing(\string $stateName): ScenarioInterface;

    /**
     * @param callable $callable
     * @return ScenarioInterface
     */
    public function run(callable $callable): ScenarioInterface;

    /**
     * @param EventInterface $event
     * @return mixed
     */
    public function __invoke(EventInterface $event);
}