<?php

namespace UniAlteri\States\LifeCycle\Tokenization;

use UniAlteri\States\Proxy\ProxyInterface;

/**
 * Interface TokenizerInterface
 * @package UniAlteri\States\LifeCycle\Tokenization
 */
interface TokenizerInterface
{
    /**
     * @param ProxyInterface $object
     * @return string
     */
    public function getStatedClassToken(ProxyInterface $object): \string;
}