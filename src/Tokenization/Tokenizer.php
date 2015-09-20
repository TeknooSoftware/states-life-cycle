<?php

namespace UniAlteri\States\LifeCycle\Tokenization;

use UniAlteri\States\LifeCycle\Event\EventInterface;
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
    protected function getStatedClassNameToken(LifeCyclableInterface $object): \string
    {
        $statedClassName = get_class($object);
        $statedClassNamePart = explode('\\', $statedClassName);
        array_pop($statedClassNamePart);

        return implode('_', $statedClassName);
    }

    /**
     * {@inheritdoc}
     */
    public function getToken(EventInterface $event): array
    {
        $object = $event->getObject();

        $statedClassName = $this->getStatedClassNameToken($object);
        $tokenList = [$statedClassName];

        foreach ($event->getEnabledStates() as $stateName) {
            $tokenList[] = $statedClassName.':'.$stateName;
        }

        foreach ($event->incomingStates() as $stateName) {
            $tokenList[] = $statedClassName.':+'.$stateName;
        }

        foreach ($event->outgoingStates() as $stateName) {
            $tokenList[] = $statedClassName.':-'.$stateName;
        }

        return $tokenList;
    }
}