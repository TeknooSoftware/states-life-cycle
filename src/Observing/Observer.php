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
 * Class Observer
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class Observer implements ObserverInterface
{
    /**
     * @var TokenizerInterface
     */
    private $tokenizer;

    /**
     * @var \ArrayAccess|EventDispatcherInterface[]
     */
    private $dispatchersList = [];

    /**
     * @var \ArrayAccess|ObservedInterface[]
     */
    private $observedList = [];

    /**
     * @var ObservedFactoryInterface
     */
    private $observedFactory;

    /**
     * @param ObservedFactoryInterface $observedFactory
     */
    public function __construct(ObservedFactoryInterface $observedFactory)
    {
        $this->dispatchersList = new \ArrayObject();
        $this->observedList = new \ArrayObject();
        $this->observedFactory = $observedFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function setTokenizer(TokenizerInterface $tokenizer): ObserverInterface
    {
        $this->tokenizer = $tokenizer;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenizer(): TokenizerInterface
    {
        return $this->tokenizer;
    }

    /**
     * {@inheritdoc}
     */
    public function addEventDispatcher(EventDispatcherInterface $dispatcher): ObserverInterface
    {
        $this->dispatchersList[spl_object_hash($dispatcher)] = $dispatcher;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeEventDispatcher(EventDispatcherInterface $dispatcher): ObserverInterface
    {
        $dispatcherHash = spl_object_hash($dispatcher);
        if (isset($this->dispatchersList[$dispatcherHash])) {
            unset($this->dispatchersList[$dispatcherHash]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function listEventDispatcher(): array
    {
        return $this->dispatchersList->getArrayCopy();
    }

    /**
     * {@inheritdoc}
     */
    public function attachObject(LifeCyclableInterface $object): ObservedInterface
    {
        $objectHash = spl_object_hash($object);
        $observed = $this->observedFactory->create($this, $object);
        $object->registerObserver($observed);

        $this->observedList[$objectHash] = $observed;

        return $observed;
    }

    /**
     * {@inheritdoc}
     */
    public function detachObject(LifeCyclableInterface $object): ObserverInterface
    {
        $objectHash = spl_object_hash($object);
        if (isset($this->observedList[$objectHash])) {
            $observed = $this->observedList[$objectHash];
            $object->unregisterObserver($observed);
            unset($this->observedList[$objectHash]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function listObserved(): array
    {
        return $this->observedList->getArrayCopy();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatchNotification(ObservedInterface $observed): ObserverInterface
    {
        $event = $observed->getLastEvent();
        $eventsNamesList = $this->getTokenizer()->getToken($event);

        foreach ($eventsNamesList as $eventName) {
            foreach ($this->dispatchersList as $dispatcher) {
                $dispatcher->dispatch($eventName, $event);
            }
        }

        return $this;
    }

}
