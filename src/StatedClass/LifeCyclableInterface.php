<?php

namespace UniAlteri\States\LifeCycle\StatedClass;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;
use UniAlteri\States\LifeCycle\Observing\ObserverInterface;
use UniAlteri\States\Proxy\ProxyInterface;

/**
 * Interface LifeCyclableInterface
 * @package UniAlteri\States\LifeCycle\StatedClass
 */
interface LifeCyclableInterface extends ProxyInterface
{
    /**
     * @return LifeCyclableInterface
     */
    public function updateState(): LifeCyclableInterface;

    /**
     * @param ObserverInterface $observer
     * @return ObservedInterface
     */
    public function registerObserver(ObserverInterface $observer): ObservedInterface;

    /**
     * @param ObservedInterface $observed
     * @return LifeCyclableInterface
     */
    public function unregisterObserver(ObservedInterface $observed): LifeCyclableInterface;

    /**
     * @return LifeCyclableInterface
     */
    public function notifyObserved(): LifeCyclableInterface;
}