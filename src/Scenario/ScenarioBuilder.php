<?php

namespace UniAlteri\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;

class ScenarioBuilder implements ScenarioBuilderInterface
{
    /**
     * @var string[]
     */
    private $eventNamesList = [];

    /**
     * @var string
     */
    private $statedClassName;

    /**
     * @var ObservedInterface
     */
    private $observed;

    /**
     * @var string[]
     */
    private $neededStatesList = [];

    /**
     * @var string[]
     */
    private $neededIncomingStatesList = [];

    /**
     * @var string[]
     */
    private $neededOutgoingStatesList = [];

    /**
     * @var callable
     */
    private $callable;

    /**
     * {@inheritdoc}
     */
    public function when(\string $eventName): ScenarioBuilderInterface
    {
        $this->eventNamesList[] = $eventName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function towardStatedClass(\string $statedClassName): ScenarioBuilderInterface
    {
        $this->statedClassName = $statedClassName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function towardObserved(ObservedInterface $observed): ScenarioBuilderInterface
    {
        $this->observed = $observed;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function ifInState(\string $stateName): ScenarioBuilderInterface
    {
        $this->neededStatesList[$stateName] = $stateName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function onIncomingState(\string $stateName): ScenarioBuilderInterface
    {
        $this->neededIncomingStatesList[$stateName] = $stateName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function onOutgoingState(\string $stateName): ScenarioBuilderInterface
    {
        $this->neededOutgoingStatesList[$stateName] = $stateName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run(callable $callable): ScenarioBuilderInterface
    {
        $this->callable = $callable;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getEventNamesList()
    {
        return $this->eventNamesList;
    }

    /**
     * @return string
     */
    public function getStatedClassName()
    {
        return $this->statedClassName;
    }

    /**
     * @return ObservedInterface
     */
    public function getObserved()
    {
        return $this->observed;
    }

    /**
     * @return \string[]
     */
    public function getNeededStatesList()
    {
        return $this->neededStatesList;
    }

    /**
     * @return \string[]
     */
    public function getNeededIncomingStatesList()
    {
        return $this->neededIncomingStatesList;
    }

    /**
     * @return \string[]
     */
    public function getNeededOutgoingStatesList()
    {
        return $this->neededOutgoingStatesList;
    }

    /**
     * @return callable
     */
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * {@inheritdoc}
     */
    public function build(): ScenarioInterface
    {
        return new Scenario($this);
    }
}