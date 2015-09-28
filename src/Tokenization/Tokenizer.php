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

        return implode('_', $statedClassNamePart);
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

        foreach ($event->getIncomingStates() as $stateName) {
            $tokenList[] = $statedClassName.':+'.$stateName;
        }

        foreach ($event->getOutgoingStates() as $stateName) {
            $tokenList[] = $statedClassName.':-'.$stateName;
        }

        return $tokenList;
    }
}