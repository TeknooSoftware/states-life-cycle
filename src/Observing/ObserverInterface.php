<?php

namespace UniAlteri\States\LifeCycle\Observing;

use UniAlteri\States\LifeCycle\Event\DispatcherInterface;
use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;

/**
 * Interface ObserverInterface
 * @package UniAlteri\States\LifeCycle\Observing
 */
interface ObserverInterface
{
    /**
     * @param DispatcherInterface $dispatcher
     * @return ObserverInterface
     */
    public function setEventDispatcher(DispatcherInterface $dispatcher): ObserverInterface;

    /**
     * @return DispatcherInterface
     */
    public function getEventDispatcher(): DispatcherInterface;

    /**
     * @param LifeCyclableInterface $object
     * @return ObservedInterface
     */
    public function attachObject(LifeCyclableInterface $object): ObservedInterface;

    /**
     * @param LifeCyclableInterface $object
     * @return ObserverInterface
     */
    public function detachObject(LifeCyclableInterface $object);

    /**
     * @param LifeCyclableInterface|ObservedInterface $observedObject
     * @return ObserverInterface
     */
    public function notifyObject($observedObject): ObserverInterface;
}