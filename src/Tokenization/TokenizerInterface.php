<?php

namespace UniAlteri\States\LifeCycle\Tokenization;

use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;

/**
 * Interface TokenizerInterface
 * @package UniAlteri\States\LifeCycle\Tokenization
 */
interface TokenizerInterface
{
    /**
     * @param LifeCyclableInterface $object
     * @return string[]
     */
    public function getStatedClassToken(LifeCyclableInterface $object): array;
}