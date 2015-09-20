<?php

namespace UniAlteri\States\LifeCycle\Observing;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;
use UniAlteri\States\LifeCycle\Tokenization\TokenizerInterface;

/**
 * Class Observer
 * @package UniAlteri\States\LifeCycle\Observing
 */
class Observer implements ObserverInterface
{
    /**
     * @var TokenizerInterface
     */
    private $tokenizer;

    /**
     * @var \ArrayAccess|EventDispatcherInterface[]
     */
    private $dispatchersList = [];

    /**
     * @var \ArrayAccess|ObservedInterface[]
     */
    private $observedList = [];

    /**
     * Default Constructor
     */
    public function __construct()
    {
        $this->dispatchersList = new \ArrayObject();
        $this->observedList = new \ArrayObject();
    }

    /**
     * {@inheritdoc}
     */
    public function setTokenizer(TokenizerInterface $tokenizer): EventDispatcherInterface
    {
        $this->tokenizer = $tokenizer;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenizer(): TokenizerInterface
    {
        return $this->tokenizer;
    }

    /**
     * {@inheritdoc}
     */
    public function addEventDispatcher(EventDispatcherInterface $dispatcher): ObserverInterface
    {
        $this->dispatchersList[spl_object_hash($dispatcher)] = $dispatcher;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeEventDispatcher(EventDispatcherInterface $dispatcher): ObserverInterface
    {
        $dispatcherHash = spl_object_hash($dispatcher);
        if (isset($this->dispatchersList[$dispatcherHash])) {
            unset($this->dispatchersList[$dispatcherHash]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function listEventDispatcher(): array
    {
        return array_values($this->dispatchersList);
    }

    /**
     * {@inheritdoc}
     */
    public function attachObject(LifeCyclableInterface $object): ObservedInterface
    {
        $objectHash = spl_object_hash($object);
        $this->observedList[$objectHash] = $object;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function detachObject(LifeCyclableInterface $object): ObserverInterface
    {
        $objectHash = spl_object_hash($object);
        if (isset($this->observedList[$objectHash])) {
            unset($this->observedList[$objectHash]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function listObserved(): array
    {
        return array_values($this->observedList);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatchNotification(ObservedInterface $observed): ObserverInterface
    {
        $event = $observed->getLastEvent();
        $eventsNamesList = $this->getTokenizer()->getStatedClassToken($observed->getObject());

        foreach ($this->dispatchersList as $dispatcher) {
            foreach ($eventsNamesList as $eventName) {
                $dispatcher->dispatch($eventName, $event);
            }
        }

        return $this;
    }

}