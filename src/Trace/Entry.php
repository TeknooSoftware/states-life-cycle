<?php

namespace UniAlteri\States\LifeCycle\Trace;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;

/**
 * Class Entry
 * @package UniAlteri\States\LifeCycle\Trace
 */
class Entry implements EntryInterface
{
    /**
     * @var ObservedInterface
     */
    private $observed;

    /**
     * @var array
     */
    private $enabledStatesList;

    /**
     * @var EntryInterface
     */
    private $previous;

    /**
     * @var EntryInterface
     */
    private $next;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        ObservedInterface $observed,
        array $enabledStatesList,
        EntryInterface $previous=null
    )
    {
        $this->observed = $observed;
        $this->enabledStatesList = $enabledStatesList;
        $this->previous = $previous;
    }

    /**
     * {@inheritdoc}
     */
    public function getObserved(): ObservedInterface
    {
        return $this->observed;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnabledState(): array
    {
        return $this->enabledStatesList;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    /**
     * {@inheritdoc}
     */
    public function setNext(EntryInterface $next): EntryInterface
    {
        $this->next = $next;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNext()
    {
        return $this->next;
    }
}