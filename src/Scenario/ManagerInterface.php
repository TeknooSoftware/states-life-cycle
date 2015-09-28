<?php

namespace UniAlteri\States\LifeCycle\Scenario;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Interface ManagerInterface
 * @package UniAlteri\States\LifeCycle\LifeCycle
 */
interface ManagerInterface
{
    /**
     * @return EventDispatcherInterface
     */
    public function getDispatcher();

    /**
     * @param EventDispatcherInterface $dispatcher
     * @return ManagerInterface
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher): ManagerInterface;

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