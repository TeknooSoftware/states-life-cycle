<?php

namespace UniAlteri\States\LifeCycle\Observing;

use UniAlteri\States\LifeCycle\Event\EventInterface;
use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;
use UniAlteri\States\LifeCycle\Trace\TraceInterface;

/**
 * Interface ObservedInterface
 * @package UniAlteri\States\LifeCycle\Observing
 */
interface ObservedInterface
{
    /**
     * @param LifeCyclableInterface $object
     * @param ObserverInterface $observer
     */
    public function __construct(LifeCyclableInterface $object, ObserverInterface $observer);

    /**
     * @return LifeCyclableInterface
     */
    public function getObject(): LifeCyclableInterface;

    /**
     * @return ObserverInterface
     */
    public function getObserver(): ObserverInterface;

    /**
     * @return string
     */
    public function getStatedClassName(): \string;

    /**
     * @return ObservedInterface
     */
    public function observeUpdate();

    /**
     * @return TraceInterface
     */
    public function getStateTrace();

    /**
     * @return EventInterface
     */
    public function getLastEvent();
}