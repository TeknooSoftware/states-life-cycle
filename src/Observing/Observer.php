<?php

namespace UniAlteri\States\LifeCycle\Observing;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;
use UniAlteri\States\LifeCycle\Tokenization\TokenizerInterface;
use UniAlteri\States\LifeCycle\Trace\Trace;

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
    public function setTokenizer(TokenizerInterface $tokenizer): ObserverInterface
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
        return $this->dispatchersList->getArrayCopy();
    }

    /**
     * {@inheritdoc}
     */
    public function attachObject(LifeCyclableInterface $object): ObservedInterface
    {
        $objectHash = spl_object_hash($object);
        $observed = new Observed($object, $this);
        $object->registerObserver($observed);

        $this->observedList[$objectHash] = $observed;

        return $observed;
    }

    /**
     * {@inheritdoc}
     */
    public function detachObject(LifeCyclableInterface $object): ObserverInterface
    {
        $objectHash = spl_object_hash($object);
        if (isset($this->observedList[$objectHash])) {
            $observed = $this->observedList[$objectHash];
            $object->unregisterObserver($observed);
            unset($this->observedList[$objectHash]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function listObserved(): array
    {
        return $this->observedList->getArrayCopy();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatchNotification(ObservedInterface $observed): ObserverInterface
    {
        $event = $observed->getLastEvent();
        $eventsNamesList = $this->getTokenizer()->getToken($event);

        foreach ($eventsNamesList as $eventName) {
            foreach ($this->dispatchersList as $dispatcher) {
                $dispatcher->dispatch($eventName, $event);
            }
        }

        return $this;
    }

}