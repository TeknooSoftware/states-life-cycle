<?php

namespace UniAlteri\States\LifeCycle\Observing;

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
     */
    public function __construct(LifeCyclableInterface $object);

    /**
     * @return LifeCyclableInterface
     */
    public function getObject(): LifeCyclableInterface;

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
}