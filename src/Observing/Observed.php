<?php

namespace UniAlteri\States\LifeCycle\Observing;

use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;
use UniAlteri\States\LifeCycle\Trace\TraceInterface;

/**
 * Class Observed
 * @package UniAlteri\States\LifeCycle\Observing
 */
class Observed implements ObservedInterface
{
    /**
     * @var LifeCyclableInterface
     */
    private $object;

    /**
     * @var ObserverInterface
     */
    private $observer;

    /**
     * @var TraceInterface
     */
    private $trace;

    /**
     * {@inheritdoc}
     */
    public function __construct(LifeCyclableInterface $object, ObserverInterface $observer, TraceInterface $trace)
    {
        $this->object = $object;
        $this->observer = $observer;
        $this->trace = $trace;
    }

    /**
     * {@inheritdoc}
     */
    public function getObject(): LifeCyclableInterface
    {
        return $this->object;
    }

    /**
     * {@inheritdoc}
     */
    public function getObserver(): ObserverInterface
    {
        return $this->observer;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatedClassName(): \string
    {
        return get_class($this->object);
    }

    /**
     * {@inheritdoc}
     */
    public function observeUpdate()
    {
        $this->getObserver()->dispatchNotification($this);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStateTrace()
    {
        return $this->trace;
    }
}