<?php

namespace UniAlteri\States\LifeCycle\Observing;

use UniAlteri\States\LifeCycle\Event\Event;
use UniAlteri\States\LifeCycle\Event\EventInterface;
use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;
use UniAlteri\States\LifeCycle\Trace\Entry;
use UniAlteri\States\LifeCycle\Trace\TraceInterface;

/**
 * Class Observed
 * @package UniAlteri\States\LifeCycle\Observing
 */
class Observed implements ObservedInterface
{
    /**
     * @var LifeCyclableInterface
     */
    private $object;

    /**
     * @var ObserverInterface
     */
    private $observer;

    /**
     * @var TraceInterface
     */
    private $trace;

    /**
     * @var EventInterface
     */
    private $lastEvent;

    /**
     * {@inheritdoc}
     */
    public function __construct(LifeCyclableInterface $object, ObserverInterface $observer, TraceInterface $trace)
    {
        $this->object = $object;
        $this->observer = $observer;
        $this->trace = $trace;
    }

    /**
     * {@inheritdoc}
     */
    public function getObject(): LifeCyclableInterface
    {
        return $this->object;
    }

    /**
     * {@inheritdoc}
     */
    public function getObserver(): ObserverInterface
    {
        return $this->observer;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatedClassName(): \string
    {
        return get_class($this->object);
    }

    /**
     * @return string[]
     */
    protected function getLastEnabledStates()
    {
        $lastEnabledStates = [];
        $lastEntry = $this->getStateTrace()->getLastEntry();
        if ($lastEntry instanceof Entry) {
            $lastEnabledStates = $lastEntry->getEnabledState();
        }

        return $lastEnabledStates;
    }

    /**
     * @return $this
     */
    protected function buildEvent()
    {
        $currentEnabledStates = $this->getObject()->listEnabledStates();
        $lastEnabledStates = $this->getLastEnabledStates();

        $incomingStates = array_diff($currentEnabledStates, $lastEnabledStates);
        $outgoingStates = array_diff($lastEnabledStates, $currentEnabledStates);

        $this->lastEvent = new Event($this, $incomingStates, $outgoingStates);

        return $this;
    }

    /**
     * @return $this
     */
    protected function updateTrace()
    {
        $trace = $this->getStateTrace();
        $trace->addEntry(
                new Entry(
                    $this,
                    $this->getObject()->listAvailableStates(),
                    $trace->getLastEntry()
                )
            );
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function observeUpdate()
    {
        $this->buildEvent()
            ->updateTrace();

        $this->getObserver()->dispatchNotification($this);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStateTrace()
    {
        return $this->trace;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastEvent()
    {
        return $this->lastEvent;
    }
}