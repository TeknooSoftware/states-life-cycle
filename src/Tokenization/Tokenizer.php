<?php

declare(strict_types=1);

/**
 * States.
 *
 * LICENSE
 *
 * This source file is subject to the MIT license and the version 3 of the GPL3
 * license that are bundled with this package in the folder licences
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to richarddeloge@gmail.com so we can send you a copy immediately.
 *
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */

namespace Teknoo\States\LifeCycle\Tokenization;

use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface;

/**
 * Class Tokenizer
 * Tokenizer to generate tokens from an event.
 *
 * Generate all tokens from an event, to be used by the event dispatcher, namespace separator are converted
 * to underscore, and the class is lowerized.
 * - a base token from the canonical stated class name
 * - a token by enabled states : "basetoken:<state name>"
 * - a token by incoming states : "basetoken:+<state name>"
 * - a token by outgoing states : "basetoken:-<state name>"
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class Tokenizer implements TokenizerInterface
{
    /**
     * To get the token from a stated class.
     *
     * @param string $statedClassName
     * @param bool   $removeProxyName
     *
     * @return string
     */
    public function getStatedClassNameToken(string $statedClassName, $removeProxyName = false): string
    {
        $statedClassNamePart = \explode('\\', $statedClassName);
        if (true === $removeProxyName) {
            \array_pop($statedClassNamePart);
        }

        return \strtolower(\implode('_', $statedClassNamePart));
    }

    /**
     * To get the token from a stated class instance.
     *
     * @param LifeCyclableInterface $object
     *
     * @return string
     */
    public function getStatedClassInstanceToken(LifeCyclableInterface $object): string
    {
        $statedClassName = \get_class($object);

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
            //Extract short class name and check if this state is not already loaded
            $shortStateName = \ltrim(\substr($stateName, (int) \strrpos($stateName, '\\')), '\\');

            $tokenList[] = $statedClassName.':'.\strtolower($shortStateName);
        }

        foreach ($event->getIncomingStates() as $stateName) {
            //Extract short class name and check if this state is not already loaded
            $shortStateName = \ltrim(\substr($stateName, (int) \strrpos($stateName, '\\')), '\\');

            $tokenList[] = $statedClassName.':+'.\strtolower($shortStateName);
        }

        foreach ($event->getOutgoingStates() as $stateName) {
            //Extract short class name and check if this state is not already loaded
            $shortStateName = \ltrim(\substr($stateName, (int) \strrpos($stateName, '\\')), '\\');

            $tokenList[] = $statedClassName.':-'.\strtolower($shortStateName);
        }

        return $tokenList;
    }
}
