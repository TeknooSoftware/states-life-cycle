<?php

namespace UniAlteri\States\LifeCycle\Event;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;
use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;

class Event implements EventInterface
{
    public function __construct(ObservedInterface $observer, array $incomingStates, array $outgoingStates)
    {
        // TODO: Implement __construct() method.
    }

    public function getObserved(): ObservedInterface
    {
        // TODO: Implement getObserved() method.
    }

    public function getObject(): LifeCyclableInterface
    {
        // TODO: Implement getObject() method.
    }

    public function getEnabledStates(): array
    {
        // TODO: Implement getEnabledStates() method.
    }

    public function incomingStates(): array
    {
        // TODO: Implement incomingStates() method.
    }

    public function outgoingStates(): array
    {
        // TODO: Implement outgoingStates() method.
    }
}