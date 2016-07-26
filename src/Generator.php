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
namespace Teknoo\States\LifeCycle;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Teknoo\States\LifeCycle\Observing\ObservedFactory;
use Teknoo\States\LifeCycle\Observing\Observer;
use Teknoo\States\LifeCycle\Observing\ObserverInterface;
use Teknoo\States\LifeCycle\Scenario\Manager;
use Teknoo\States\LifeCycle\Scenario\ManagerInterface;
use Teknoo\States\LifeCycle\Tokenization\Tokenizer;
use Teknoo\States\LifeCycle\Tokenization\TokenizerInterface;

/**
 * Class Generator
 * Class to generate some instance of objects needed to use easily this library *.
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class Generator
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var ManagerInterface
     */
    private $manager;

    /**
     * @var ObserverInterface
     */
    private $observer;

    /**
     * @var TokenizerInterface
     */
    private $tokenizer;

    /**
     * @return TokenizerInterface|Tokenizer
     */
    public function getTokenizer(): TokenizerInterface
    {
        if (!$this->tokenizer instanceof TokenizerInterface) {
            $this->tokenizer = new Tokenizer();
        }

        return $this->tokenizer;
    }

    /**
     * @param TokenizerInterface $tokenizer
     */
    public function setTokenizer($tokenizer): Generator
    {
        $this->tokenizer = $tokenizer;

        return $this;
    }

    /**
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher(): EventDispatcherInterface
    {
        if (!$this->eventDispatcher instanceof EventDispatcherInterface) {
            $this->eventDispatcher = new EventDispatcher();
        }

        return $this->eventDispatcher;
    }

    /**
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return self
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): Generator
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }

    /**
     * @return ManagerInterface
     */
    public function getManager(): ManagerInterface
    {
        if (!$this->manager instanceof ManagerInterface) {
            $this->manager = new Manager($this->getEventDispatcher());
        }

        return $this->manager;
    }

    /**
     * @param ManagerInterface $manager
     *
     * @return self
     */
    public function setManager(ManagerInterface $manager): Generator
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return ObserverInterface
     */
    public function getObserver(): ObserverInterface
    {
        if (!$this->observer instanceof ObserverInterface) {
            $observedFactory = new ObservedFactory(
                'Teknoo\States\LifeCycle\Observing\Observed',
                'Teknoo\States\LifeCycle\Event\Event',
                'Teknoo\States\LifeCycle\Trace\Trace'
            );

            $this->observer = new Observer($observedFactory);
            $this->observer->addEventDispatcher($this->getEventDispatcher());
            $this->observer->setTokenizer($this->getTokenizer());
        }

        return $this->observer;
    }

    /**
     * @param ObserverInterface $observer
     *
     * @return self
     */
    public function setObserver(ObserverInterface $observer): Generator
    {
        $this->observer = $observer;

        return $this;
    }
}
