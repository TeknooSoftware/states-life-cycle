<?php

namespace UniAlteri\States\LifeCycle\Observing;

use UniAlteri\States\LifeCycle\Trace\TraceInterface;
use UniAlteri\States\Proxy\ProxyInterface;

/**
 * Interface ObservedInterface
 * @package UniAlteri\States\LifeCycle\Observing
 */
interface ObservedInterface
{
    /**
     * @param ProxyInterface $proxyInterface
     */
    public function __construct(ProxyInterface $proxyInterface);

    /**
     * @return string
     */
    public function getId(): \string;

    /**
     * @return ProxyInterface
     */
    public function getObject(): ProxyInterface;

    /**
     * @return string
     */
    public function getStatedClassName(): \string;

    /**
     * @return TraceInterface
     */
    public function getStateTrace();
}