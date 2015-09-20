<?php

namespace UniAlteri\States\LifeCycle\Trace;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;

/**
 * Interface EntityInterface
 * @package UniAlteri\States\LifeCycle\Trace
 */
interface EntityInterface
{
    /**
     * @param ObservedInterface $observedInterface
     * @param string[] $enabledStatesList
     */
    public function __construct(ObservedInterface $observedInterface, array $enabledStatesList);

    /**
     * @return ObservedInterface
     */
    public function getObserved(): ObservedInterface;

    /**
     * @return string[]
     */
    public function getEnabledState(): array;

    /**
     * @return EntityInterface
     */
    public function getPrevious(): EntityInterface;

    /**
     * @return EntityInterface
     */
    public function getNext(): EntityInterface;
}