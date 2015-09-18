<?php

namespace UniAlteri\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Event\DispatcherInterface;

/**
 * Interface ManagerInterface
 * @package UniAlteri\States\LifeCycle\LifeCycle
 */
interface ManagerInterface
{
    /**
     * @param DispatcherInterface $dispatcher
     * @return ManagerInterface
     */
    public function setDispatcher(DispatcherInterface $dispatcher): ManagerInterface;

    /**
     * @return DispatcherInterface
     */
    public function getDispatcher(): DispatcherInterface;

    /**
     * @param ScenarioInterface $scenario
     * @return ManagerInterface
     */
    public function registerScenario(ScenarioInterface $scenario): ManagerInterface;

    /**
     * @param ScenarioInterface $scenario
     * @return ManagerInterface
     */
    public function unregisterScenario(ScenarioInterface $scenario): ManagerInterface;

    /**
     * @return ScenarioInterface[]
     */
    public function listScenarii(): array;
}