<?php

namespace UniAlteri\States\LifeCycle\Event;

/**
 * Interface DispatcherInterface
 * @package UniAlteri\States\LifeCycle\Event
 */
interface DispatcherInterface
{
    /**
     * @param EventInterface $event
     * @return DispatcherInterface
     */
    public function notify(EventInterface $event): DispatcherInterface;
}