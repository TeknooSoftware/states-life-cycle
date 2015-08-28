<?php

namespace UniAlteri\States\LifeCycle\Event;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;
use UniAlteri\States\Proxy\ProxyInterface;

/**
 * Interface EventInterface
 * @package UniAlteri\States\LifeCycle\Event
 */
interface EventInterface
{
    /**
     * @param ObservedInterface $observer
     * @param array $incomingStates
     * @param array $outgoingStates
     * @return mixed
     */
    public function __construct(ObservedInterface $observer, array $incomingStates, array $outgoingStates);

    /**
     * @return ObservedInterface
     */
    public function getObserved(): ObservedInterface;

    /**
     * @return ProxyInterface
     */
    public function getObject(): ProxyInterface;

    /**
     * @return string[]
     */
    public function getEnabledStates(): array;

    /**
     * @return string[]
     */
    public function incomingStates(): array;

    /**
     * @return string[]
     */
    public function outgoingStates(): array;
}