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

namespace UniAlteri\States\LifeCycle;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use UniAlteri\States\LifeCycle\Observing\ObservedFactory;
use UniAlteri\States\LifeCycle\Observing\Observer;
use UniAlteri\States\LifeCycle\Observing\ObserverInterface;
use UniAlteri\States\LifeCycle\Scenario\Manager;
use UniAlteri\States\LifeCycle\Scenario\ManagerInterface;

/**
 * @return EventDispatcherInterface
 */
function getEventDispatcher(): EventDispatcherInterface
{
    static $dispatcher = new EventDispatcher();

    return $dispatcher;
}

/**
 * @param EventDispatcherInterface $dispatcher
 * @return ManagerInterface
 */
function getScenariiManager(EventDispatcherInterface $dispatcher): ManagerInterface
{
    static $manager = new Manager($dispatcher);

    return $manager;
}

/**
 * @param EventDispatcherInterface $dispatcher
 * @return ObserverInterface
 */
function getObserver(EventDispatcherInterface $dispatcher): ObserverInterface
{
    static $observer = null;

    if (!$observer instanceof ObserverInterface) {
        $observedFactory = new ObservedFactory(
            'UniAlteri\States\LifeCycle\Observing\Observed',
            'UniAlteri\States\LifeCycle\Event\Event',
            'UniAlteri\States\LifeCycle\Trace\Trace'
        );

        $observer = new Observer($observedFactory);
        $observer->addEventDispatcher($dispatcher);
    }

    return $observer;
}