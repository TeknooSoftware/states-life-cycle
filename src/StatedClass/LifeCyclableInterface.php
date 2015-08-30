<?php

namespace UniAlteri\States\LifeCycle\StatedClass;

use UniAlteri\States\LifeCycle\Observing\ObserverInterface;
use UniAlteri\States\Proxy\ProxyInterface;

/**
 * Interface LifeCyclableInterface
 * @package UniAlteri\States\LifeCycle\StatedClass
 */
interface LifeCyclableInterface extends ProxyInterface
{
    /**
     * @return ProxyInterface
     */
    public function updateState(): ProxyInterface;

    /**
     * @param ObserverInterface $observer
     * @return LifeCyclableInterface
     */
    public function registerObserver(ObserverInterface $observer): LifeCyclableInterface;

    /**
     * @param ObserverInterface $observer
     * @return LifeCyclableInterface
     */
    public function unregisterObserver(ObserverInterface $observer): LifeCyclableInterface;

    /**
     * @return LifeCyclableInterface
     */
    public function notifyObserver(): LifeCyclableInterface;
}