<?php

namespace UniAlteri\States\LifeCycle\Event;

use UniAlteri\States\LifeCycle\Tokenization\TokenizerInterface;

/**
 * Interface DispatcherInterface
 * @package UniAlteri\States\LifeCycle\Event
 */
interface DispatcherInterface
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
     * @param EventInterface $event
     * @return DispatcherInterface
     */
    public function notify(EventInterface $event): DispatcherInterface;
}