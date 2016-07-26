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
 * to richarddeloge@gmail.com so we can send you a copy immediately.
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
 * Interface to manage several observations of stated class instances and distpatch change to the system
 * via one or several event dispatcher.
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
     * To register the tokenizer to generate events name to use to distpach changes.
     *
     * @param TokenizerInterface $tokenizer
     *
     * @return ObserverInterface
     */
    public function setTokenizer(TokenizerInterface $tokenizer): ObserverInterface;

    /**
     * To get the tokenizer to generate events name to use to distpach changes.
     *
     * @return TokenizerInterface
     */
    public function getTokenizer(): TokenizerInterface;

    /**
     * To register a dispatcher to use to dispatch an event from an observed's change.
     *
     * @param EventDispatcherInterface $dispatcher
     *
     * @return ObserverInterface
     */
    public function addEventDispatcher(EventDispatcherInterface $dispatcher): ObserverInterface;

    /**
     * To unregister a dispatcher to use to dispatch an event from an observed's change.
     *
     * @param EventDispatcherInterface $dispatcher
     *
     * @return ObserverInterface
     */
    public function removeEventDispatcher(EventDispatcherInterface $dispatcher): ObserverInterface;

    /**
     * To list all dispatchers to use to dispatch an event from an observed's change.
     *
     * @return EventDispatcherInterface[]
     */
    public function listEventDispatcher(): array;

    /**
     * To observe a new stated class instance to dispatch instance's change.
     *
     * @param LifeCyclableInterface $object
     *
     * @return ObservedInterface
     */
    public function attachObject(LifeCyclableInterface $object): ObservedInterface;

    /**
     * To unobserve a stated class instance previously registered with attachObject().
     *
     * @param LifeCyclableInterface $object
     *
     * @return ObserverInterface
     */
    public function detachObject(LifeCyclableInterface $object): ObserverInterface;

    /**
     * To list all observed stated class instance attached to this observer.
     *
     * @return ObservedInterface[]
     */
    public function listObserved(): array;

    /**
     * To extract change from a stated class instance and broadcast change to the system.
     *
     * @param ObservedInterface $observed
     *
     * @return ObserverInterface
     */
    public function dispatchNotification(ObservedInterface $observed): ObserverInterface;
}
