<?php

namespace UniAlteri\States\LifeCycle\Observing;

use UniAlteri\States\LifeCycle\Event\DispatcherInterface;
use UniAlteri\States\Proxy\ProxyInterface;

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
     * @param ProxyInterface $object
     * @return ObservedInterface
     */
    public function attachObject(ProxyInterface $object): ObservedInterface;

    /**
     * @param ObservedInterface $observed
     * @return ObserverInterface
     */
    public function closeObserving(ObservedInterface $observed): ObserverInterface;

    /**
     * @param ProxyInterface $object
     * @return ObserverInterface
     */
    public function detachObject(ProxyInterface $object): ObserverInterface;

    /**
     * @param ProxyInterface|ObservedInterface $observedObject
     * @return ObserverInterface
     */
    public function notifyObject($observedObject): ObserverInterface;
}