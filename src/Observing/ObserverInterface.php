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
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */

namespace Teknoo\States\LifeCycle\Observing;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface;
use Teknoo\States\LifeCycle\Tokenization\TokenizerInterface;

/**
 * Interface ObserverInterface
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
interface ObserverInterface
{
    /**
     * @param TokenizerInterface $tokenizer
     * @return ObserverInterface
     */
    public function setTokenizer(TokenizerInterface $tokenizer): ObserverInterface;

    /**
     * @return TokenizerInterface
     */
    public function getTokenizer(): TokenizerInterface;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @return ObserverInterface
     */
    public function addEventDispatcher(EventDispatcherInterface $dispatcher): ObserverInterface;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @return ObserverInterface
     */
    public function removeEventDispatcher(EventDispatcherInterface $dispatcher): ObserverInterface;

    /**
     * @return EventDispatcherInterface[]
     */
    public function listEventDispatcher(): array;

    /**
     * @param LifeCyclableInterface $object
     * @return ObservedInterface
     */
    public function attachObject(LifeCyclableInterface $object): ObservedInterface;

    /**
     * @param LifeCyclableInterface $object
     * @return ObserverInterface
     */
    public function detachObject(LifeCyclableInterface $object): ObserverInterface;

    /**
     * @return ObservedInterface[]
     */
    public function listObserved(): array;

    /**
     * @param ObservedInterface $observed
     * @return ObserverInterface
     */
    public function dispatchNotification(ObservedInterface $observed): ObserverInterface;
}