<?php

namespace UniAlteri\States\LifeCycle\Trace;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;

/**
 * Interface TraceInterface
 * @package UniAlteri\States\LifeCycle\Trace
 */
interface TraceInterface
{
    /**
     * @param ObservedInterface $observedInterface
     */
    public function __construct(ObservedInterface $observedInterface);

    /**
     * @return ObservedInterface
     */
    public function getObserved(): ObservedInterface;

    /**
     * @return \SplStack|EntryInterface[]
     */
    public function getTrace(): \SplStack;

    /**
     * @return bool
     */
    public function isEmpty(): \bool;

    /**
     * @return EntryInterface
     */
    public function getFirstEntry(): EntryInterface;

    /**
     * @return EntryInterface
     */
    public function getLastEntry(): EntryInterface;

    /**
     * @param EntryInterface $entry
     * @return TraceInterface
     */
    public function addEntry(EntryInterface $entry): TraceInterface;
}