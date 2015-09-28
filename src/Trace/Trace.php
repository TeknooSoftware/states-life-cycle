<?php

namespace UniAlteri\States\LifeCycle\Trace;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;

/**
 * Class Trace
 * @package UniAlteri\States\LifeCycle\Trace
 */
class Trace implements TraceInterface
{
    /**
     * @var ObservedInterface;
     */
    private $observed;

    /**
     * @var \SplStack
     */
    private $stack;

    /**
     * {@inheritdoc}
     */
    public function __construct(ObservedInterface $observedInterface)
    {
        $this->observed = $observedInterface;
        $this->stack = new \SplStack();
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
    public function getTrace(): \SplStack
    {
        return $this->stack;
    }

    /**
     * @return bool
     */
    public function isEmpty(): \bool
    {
        return 0 === $this->stack->count();
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstEntry(): EntryInterface
    {
        if (0 === $this->stack->count()) {
            throw new \RuntimeException('Trace empty');
        }

        return $this->stack->bottom();
    }

    /**
     * {@inheritdoc}
     */
    public function getLastEntry(): EntryInterface
    {
        if (0 === $this->stack->count()) {
            throw new \RuntimeException('Trace empty');
        }

        return $this->stack->top();
    }

    /**
     * {@inheritdoc}
     */
    public function addEntry(EntryInterface $entry): TraceInterface
    {
        if (false === $this->isEmpty()) {
            $lastEntry = $this->getLastEntry();
            $lastEntry->setNext($entry);
        }

        $this->stack->push($entry);

        return $this;
    }
}