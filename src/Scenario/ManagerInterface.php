<?php

namespace UniAlteri\States\LifeCycle\Scenario;

/**
 * Interface ManagerInterface
 * @package UniAlteri\States\LifeCycle\LifeCycle
 */
interface ManagerInterface
{
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