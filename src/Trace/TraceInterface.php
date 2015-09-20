<?php

namespace UniAlteri\States\LifeCycle\Trace;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;
use UniAlteri\States\LifeCycle\Observing\ObserverInterface;

/**
 * Interface TraceInterface
 * @package UniAlteri\States\LifeCycle\Trace
 */
interface TraceInterface
{
    /**
     * @param ObservedInterface $observedInterface
     */
    public function __construct(ObservedInterface $observedInterface);

    /**
     * @return ObservedInterface
     */
    public function getObserved(): ObservedInterface;

    /**
     * @return \SplStack|EntityInterface[]
     */
    public function getTrace(): \SplStack;

    /**
     * @return EntityInterface
     */
    public function getFirstEntry(): EntityInterface;

    /**
     * @return EntityInterface
     */
    public function getLastEntry(): EntityInterface;
}