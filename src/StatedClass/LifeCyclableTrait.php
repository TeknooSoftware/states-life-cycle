<?php

namespace UniAlteri\States\LifeCycle\StatedClass;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;

/**
 * Class LifeCyclableTrait
 * @package UniAlteri\States\LifeCycle\StatedClass
 */
trait LifeCyclableTrait
{
    /**
     * @var ObservedInterface[]
     */
    private $observedList = [];

    /**
     * @param ObservedInterface $observed
     * @return LifeCyclableInterface
     */
    public function registerObserver(ObservedInterface $observed): LifeCyclableInterface
    {
        $this->observedList[spl_object_hash($observed)] = $observed;

        return $this;
    }

    /**
     * @param ObservedInterface $observed
     * @return LifeCyclableInterface
     */
    public function unregisterObserver(ObservedInterface $observed): LifeCyclableInterface
    {
        $observedHash = spl_object_hash($observed);

        if (isset($this->observedList[$observedHash])) {
            return $this->observedList[$observedHash];
        }

        return $this;
    }

    /**
     * @return LifeCyclableInterface
     */
    public function notifyObserved(): LifeCyclableInterface
    {
        foreach ($this->observedList as $observed) {
            $observed->observeUpdate();
        }

        return $this;
    }
}