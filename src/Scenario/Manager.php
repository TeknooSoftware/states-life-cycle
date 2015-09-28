<?php

namespace UniAlteri\States\LifeCycle\Scenario;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class Manager
 * @package UniAlteri\States\LifeCycle\Scenario
 */
class Manager implements ManagerInterface
{
    /**
     * @var ScenarioInterface[]|\ArrayAccess
     */
    private $scenariiList = [];

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->setDispatcher($dispatcher);
    }

    /**
     * @return EventDispatcherInterface
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * @param EventDispatcherInterface $dispatcher
     * @return EventDispatcherInterface
     */
    public function setDispatcher($dispatcher): ManagerInterface
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    /**
     * @param ScenarioInterface $scenario
     * @return $this
     */
    protected function addEventsAboutScenario(ScenarioInterface $scenario)
    {
        $dispatcher = $this->getDispatcher();
        foreach ($scenario->getEventsNamesList() as $eventName) {
            $dispatcher->addListener($eventName, $scenario);
        }

        return $this;
    }

    /**
     * @param ScenarioInterface $scenario
     * @return $this
     */
    protected function removeEventsAboutScenario(ScenarioInterface $scenario)
    {
        $dispatcher = $this->getDispatcher();
        foreach ($scenario->getEventsNamesList() as $eventName) {
            $dispatcher->removeListener($eventName, $scenario);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function registerScenario(ScenarioInterface $scenario): ManagerInterface
    {
        $this->scenariiList[spl_object_hash($scenario)] = $scenario;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function unregisterScenario(ScenarioInterface $scenario): ManagerInterface
    {
        $scenarioHash = spl_object_hash($scenario);

        if (isset($this->scenariiList[$scenarioHash])) {
            $this->removeEventsAboutScenario($scenario);
            unset($this->scenariiList[$scenarioHash]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function listScenarii(): array
    {
        return $this->scenariiList;
    }
}