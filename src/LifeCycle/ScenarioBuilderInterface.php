<?php

namespace UniAlteri\States\LifeCycle\LifeCycle;
use UniAlteri\States\LifeCycle\Observing\ObservedInterface;

/***
 * Interface ScenarioBuilderInterface
 * @package UniAlteri\States\LifeCycle\LifeCycle
 */
interface ScenarioBuilderInterface
{
    /**
     * @param string $statedClassName
     * @return ScenarioBuilderInterface
     */
    public function towardStatedClass(\string $statedClassName): ScenarioBuilderInterface;

    /**
     * @param ObservedInterface $observed
     * @return ScenarioBuilderInterface
     */
    public function towardObserved(ObservedInterface $observed): ScenarioBuilderInterface;

    /**
     * @return ScenarioBuilderInterface
     */
    public function onNew(): ScenarioBuilderInterface;

    /**
     * @return ScenarioBuilderInterface
     */
    public function onClone(): ScenarioBuilderInterface;

    /**
     * @return ScenarioBuilderInterface
     */
    public function onDelete(): ScenarioBuilderInterface;

    /**
     * @return ScenarioBuilderInterface
     */
    public function onSleep(): ScenarioBuilderInterface;

    /**
     * @return ScenarioBuilderInterface
     */
    public function onWakeUp(): ScenarioBuilderInterface;

    /**
     * @param string $stateName
     * @return ScenarioBuilderInterface
     */
    public function ifInState(\string $stateName): ScenarioBuilderInterface;

    /**
     * @param string $stateName
     * @return ScenarioBuilderInterface
     */
    public function onIncomingState(\string $stateName): ScenarioBuilderInterface;

    /**
     * @param string $stateName
     * @return ScenarioBuilderInterface
     */
    public function onOutgoingState(\string $stateName): ScenarioBuilderInterface;

    /**
     * @param callable $callable
     * @return ScenarioBuilderInterface
     */
    public function run(callable $callable): ScenarioBuilderInterface;

    /**
     * @return ScenarioInterface
     */
    public function build(): ScenarioInterface;
}