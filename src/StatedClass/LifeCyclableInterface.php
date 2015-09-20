<?php

namespace UniAlteri\States\LifeCycle\StatedClass;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;
use UniAlteri\States\Proxy\ProxyInterface;

/**
 * Interface LifeCyclableInterface
 * @package UniAlteri\States\LifeCycle\StatedClass
 */
interface LifeCyclableInterface extends ProxyInterface
{
    /**
     * @param ObservedInterface $observed
     * @return LifeCyclableInterface
     */
    public function registerObserver(ObservedInterface $observed): LifeCyclableInterface;

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