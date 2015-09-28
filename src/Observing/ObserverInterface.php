<?php

namespace UniAlteri\States\LifeCycle\Observing;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;
use UniAlteri\States\LifeCycle\Tokenization\TokenizerInterface;

/**
 * Interface ObserverInterface
 * @package UniAlteri\States\LifeCycle\Observing
 */
interface ObserverInterface
{
    /**
     * @param TokenizerInterface $tokenizer
     * @return ObserverInterface
     */
    public function setTokenizer(TokenizerInterface $tokenizer): ObserverInterface;

    /**
     * @return TokenizerInterface
     */
    public function getTokenizer(): TokenizerInterface;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @return ObserverInterface
     */
    public function addEventDispatcher(EventDispatcherInterface $dispatcher): ObserverInterface;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @return ObserverInterface
     */
    public function removeEventDispatcher(EventDispatcherInterface $dispatcher): ObserverInterface;

    /**
     * @return EventDispatcherInterface[]
     */
    public function listEventDispatcher(): array;

    /**
     * @param LifeCyclableInterface $object
     * @return ObservedInterface
     */
    public function attachObject(LifeCyclableInterface $object): ObservedInterface;

    /**
     * @param LifeCyclableInterface $object
     * @return ObserverInterface
     */
    public function detachObject(LifeCyclableInterface $object): ObserverInterface;

    /**
     * @return ObservedInterface[]
     */
    public function listObserved(): array;

    /**
     * @param ObservedInterface $observed
     * @return ObserverInterface
     */
    public function dispatchNotification(ObservedInterface $observed): ObserverInterface;
}