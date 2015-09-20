<?php

namespace UniAlteri\States\LifeCycle\Event;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;
use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

/**
 * Class Event
 * @package UniAlteri\States\LifeCycle\Event
 */
class Event extends SymfonyEvent implements EventInterface
{
    /**
     * @var ObservedInterface
     */
    private $observed;

    /**
     * @var string[]
     */
    private $incomingStates;

    /**
     * @var string[]
     */
    private $outgoingStates;

    /**
     * {@inheritdoc}
     */
    public function __construct(ObservedInterface $observer, array $incomingStates, array $outgoingStates)
    {
        $this->observed = $observer;
        $this->incomingStates = $incomingStates;
        $this->outgoingStates = $outgoingStates;
    }

    /**
     * {@inheritdoc}
     */
    public function getObserved(): ObservedInterface
    {
        return $this->observed;
    }

    /**
     * {@inheritdoc}
     */
    public function getObject(): LifeCyclableInterface
    {
        return $this->getObserved()->getObject();
    }

    /**
     * {@inheritdoc}
     */
    public function getEnabledStates(): array
    {
        return $this->getObject()->listEnabledStates();
    }

    /**
     * {@inheritdoc}
     */
    public function incomingStates(): array
    {
        return $this->incomingStates;
    }

    /**
     * {@inheritdoc}
     */
    public function outgoingStates(): array
    {
        return $this->outgoingStates;
    }
}