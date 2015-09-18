<?php

namespace UniAlteri\States\LifeCycle\Observing;

use UniAlteri\States\LifeCycle\Event\DispatcherInterface;
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
     * @return DispatcherInterface
     */
    public function setTokenizer(TokenizerInterface $tokenizer): DispatcherInterface;

    /**
     * @return TokenizerInterface
     */
    public function getTokenizer(): TokenizerInterface;

    /**
     * @param DispatcherInterface $dispatcher
     * @return ObserverInterface
     */
    public function addEventDispatcher(DispatcherInterface $dispatcher): ObserverInterface;

    /**
     * @param DispatcherInterface $dispatcher
     * @return ObserverInterface
     */
    public function removeEventDispatcher(DispatcherInterface $dispatcher): ObserverInterface;

    /**
     * @return DispatcherInterface[]
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