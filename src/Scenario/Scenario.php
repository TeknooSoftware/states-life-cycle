<?php

namespace UniAlteri\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Event\EventInterface;
use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;

class Scenario implements ScenarioInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @var string[]
     */
    private $eventsNamesList;

    /**
     * @var string[]
     */
    private $neededIncomingStatesList;

    /**
     * @var string[]
     */
    private $neededOutgoingStatesList;

    /**
     * @var string[]
     */
    private $neededStatesList;

    /**
     * @var string
     */
    private $neededStatedClassName;

    /**
     * @var LifeCyclableInterface
     */
    private $neededStatedObject;

    /**
     * {@inheritdoc}
     */
    public function getEventsNamesList(): array
    {
        return $this->eventsNamesList;
    }

    /**
     * @return string[]
     */
    public function listNeededIncomingStates(): array
    {
        return $this->neededIncomingStatesList;
    }

    /**
     * @return string[]
     */
    public function listNeededOutgoingStates(): array
    {
        return $this->neededOutgoingStatesList;
    }

    /**
     * @return string[]
     */
    public function listNeededStates(): array
    {
        return $this->neededStatesList;
    }

    /**
     * @return string
     */
    public function getNeededStatedClass(): \string
    {
        return $this->neededStatedClassName;
    }

    /**
     * @return LifeCyclableInterface
     */
    public function getNeededStatedObject(): LifeCyclableInterface
    {
        return $this->neededStatedObject;
    }

    /**
     * {@inheritdoc}
     */
    public function isAllowedToRun(EventInterface $event): \bool
    {

    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(EventInterface $event)
    {
        if ($this->isAllowedToRun($event)) {
            $callback = $this->callback;
            $callback($event);
        }
    }
}