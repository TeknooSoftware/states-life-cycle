<?php

namespace UniAlteri\States\LifeCycle\Trace;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;

/**
 * Interface EntryInterface
 * @package UniAlteri\States\LifeCycle\Trace
 */
interface EntryInterface
{
    /**
     * @param ObservedInterface $observed
     * @param string[] $enabledStatesList
     * @param EntryInterface|null $previous
     */
    public function __construct(
        ObservedInterface $observed,
        array $enabledStatesList,
        EntryInterface $previous=null
    );

    /**
     * @return ObservedInterface
     */
    public function getObserved(): ObservedInterface;

    /**
     * @return string[]
     */
    public function getEnabledState(): array;

    /**
     * @return EntryInterface
     */
    public function getPrevious(): EntryInterface;

    /**
     * @param EntryInterface $next
     * @return EntryInterface
     */
    public function setNext(EntryInterface $next): EntryInterface;

    /**
     * @return EntryInterface
     */
    public function getNext(): EntryInterface;
}