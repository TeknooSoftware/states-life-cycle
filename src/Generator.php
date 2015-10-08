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

namespace UniAlteri\States\LifeCycle;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use UniAlteri\States\LifeCycle\Observing\ObservedFactory;
use UniAlteri\States\LifeCycle\Observing\Observer;
use UniAlteri\States\LifeCycle\Observing\ObserverInterface;
use UniAlteri\States\LifeCycle\Scenario\Manager;
use UniAlteri\States\LifeCycle\Scenario\ManagerInterface;

/**
 * Class Generator
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
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
                'UniAlteri\States\LifeCycle\Observing\Observed',
                'UniAlteri\States\LifeCycle\Event\Event',
                'UniAlteri\States\LifeCycle\Trace\Trace'
            );

            $this->observer = new Observer($observedFactory);
            $this->observer->addEventDispatcher($this->getEventDispatcher());
        }

        return $this->observer;
    }

    /**
     * @param ObserverInterface $observer
     * @return self
     */
    public function setObserver(ObserverInterface $observer): Generator
    {
        $this->observer = $observer;

        return $this;
    }
}