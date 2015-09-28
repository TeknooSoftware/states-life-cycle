<?php

namespace UniAlteri\States\LifeCycle\Tokenization;

use UniAlteri\States\LifeCycle\Event\EventInterface;

/**
 * Interface TokenizerInterface
 * @package UniAlteri\States\LifeCycle\Tokenization
 */
interface TokenizerInterface
{
    /**
     * @param EventInterface $event
     * @return string[]
     */
    public function getToken(EventInterface $event): array;
}