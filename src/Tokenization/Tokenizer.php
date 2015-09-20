<?php

namespace UniAlteri\States\LifeCycle\Tokenization;

use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;

/**
 * Class Tokenizer
 * @package UniAlteri\States\LifeCycle\Tokenization
 */
class Tokenizer implements TokenizerInterface
{
    /**
     * @param LifeCyclableInterface $object
     * @return string
     */
    protected function getStatedClassName(LifeCyclableInterface $object): \string
    {
        $statedClassName = get_class($object);
        $statedClassNamePart = explode('\\', $statedClassName);
        array_pop($statedClassNamePart);

        return implode('\\', $statedClassName);
    }

    /**
     * @param LifeCyclableInterface $object
     * @return string[]
     */
    protected function getEnabledStates(LifeCyclableInterface $object): array
    {
        return $object->listEnabledStates();
    }

    /**
     * {@inheritdoc}
     */
    public function getStatedClassToken(LifeCyclableInterface $object): array
    {
        $tokenList = [];
        $statedClassName = $this->getStatedClassName($object);

        foreach ($this->getEnabledStates($object) as $stateName) {
            $tokenList[] = $statedClassName.':'.$stateName;
        }

        return $tokenList;
    }
}