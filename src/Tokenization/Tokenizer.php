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
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
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
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class Tokenizer implements TokenizerInterface
{
    /**
     * @param string $statedClassName
     * @param bool $removeProxyName
     * @return string
     */
    public function getStatedClassNameToken(\string $statedClassName, $removeProxyName=false): \string
    {
        $statedClassNamePart = explode('\\', $statedClassName);
        if (true === $removeProxyName) {
            array_pop($statedClassNamePart);
        }

        return strtolower(implode('_', $statedClassNamePart));
    }

    /**
     * @param LifeCyclableInterface $object
     * @return string
     */
    public function getStatedClassInstanceToken(LifeCyclableInterface $object): \string
    {
        $statedClassName = get_class($object);

        return $this->getStatedClassNameToken($statedClassName, true);
    }

    /**
     * {@inheritdoc}
     */
    public function getToken(EventInterface $event): array
    {
        $object = $event->getObject();

        $statedClassName = $this->getStatedClassInstanceToken($object);
        $tokenList = [$statedClassName];

        foreach ($event->getEnabledStates() as $stateName) {
            $tokenList[] = $statedClassName.':'.strtolower($stateName);
        }

        foreach ($event->getIncomingStates() as $stateName) {
            $tokenList[] = $statedClassName.':+'.strtolower($stateName);
        }

        foreach ($event->getOutgoingStates() as $stateName) {
            $tokenList[] = $statedClassName.':-'.strtolower($stateName);
        }

        return $tokenList;
    }
}