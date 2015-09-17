<?php

namespace UniAlteri\States\LifeCycle\LifeCycle;

use UniAlteri\States\LifeCycle\Listening\ListenerInterface;

/***
 * Interface ScenarioBuilderInterface
 * @package UniAlteri\States\LifeCycle\LifeCycle
 */
interface ScenarioBuilderInterface extends ListenerInterface
{
    /**
     * @param string $statedClassName
     * @return ScenarioBuilderInterface
     */
    public function toward(\string $statedClassName): ScenarioBuilderInterface;

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
    public function incoming(\string $stateName): ScenarioBuilderInterface;

    /**
     * @param string $stateName
     * @return ScenarioBuilderInterface
     */
    public function outgoing(\string $stateName): ScenarioBuilderInterface;

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