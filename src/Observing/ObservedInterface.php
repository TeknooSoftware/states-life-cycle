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
     * @return string
     */
    public function getId(): \string;

    /**
     * @return LifeCyclableInterface
     */
    public function getObject(): LifeCyclableInterface;

    /**
     * @return string
     */
    public function getStatedClassName(): \string;

    /**
     * @return TraceInterface
     */
    public function getStateTrace();
}