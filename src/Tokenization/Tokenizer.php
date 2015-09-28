<?php

/**
 * States.
 *
 * LICENSE
 *
 * This source file is subject to the MIT license and the version 3 of the GPL3
 * license that are bundled with this package in the folder licences
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@uni-alteri.com so we can send you a copy immediately.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\States\LifeCycle\Tokenization;

use UniAlteri\States\LifeCycle\Event\EventInterface;
use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;

/**
 * Class Tokenizer
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
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