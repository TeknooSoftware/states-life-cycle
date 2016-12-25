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
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */

namespace demo;

include dirname(__DIR__).'/vendor/autoload.php';

use demo\LifeCyclableAcme\LifeCyclableAcme;
use demo\LifeCyclableAcme\States\State1;
use demo\LifeCyclableAcme\States\State2;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\Generator;

//Use the helper generator to get needed instance of observer and event dispatcher, it's not a mandatory tool
$generator = new Generator();
$generator->setEventClassName(Event::class);
$generator->setEventDispatcher(new EventDispatcherBridge(new EventDispatcher()));
$eventDistpatcher = $generator->getEventDispatcher();

$eventDistpatcher->addListener('demo_lifecyclableacme', function (EventInterface $event) {
    echo PHP_EOL.PHP_EOL.'Listen event "demo_lifecyclableacme"';
    echo PHP_EOL.'New event from an instance demo\\LifeCyclableAcme, hash : '.spl_object_hash($event->getObject());
    echo PHP_EOL.'Enabled states : '.implode(', ', $event->getEnabledStates());
    echo PHP_EOL.'Incoming states : '.implode(', ', $event->getIncomingStates());
    echo PHP_EOL.'Outgoing states : '.implode(', ', $event->getOutgoingStates());
});

$eventDistpatcher->addListener('demo_lifecyclableacme:+state1', function (EventInterface $event) {
    echo PHP_EOL.PHP_EOL.'Listen event "demo_lifecyclableacme:+state1"';
    echo PHP_EOL.'Instance demo\\LifeCyclableAcme incoming in state 1, hash : '.spl_object_hash($event->getObject());
});

$eventDistpatcher->addListener('demo_lifecyclableacme:+state2', function (EventInterface $event) {
    echo PHP_EOL.PHP_EOL.'Listen event "demo_lifecyclableacme:+state2"';
    echo PHP_EOL.'Instance demo\\LifeCyclableAcme incoming in state 2, hash : '.spl_object_hash($event->getObject());
});

$eventDistpatcher->addListener('demo_lifecyclableacme:-state1', function (EventInterface $event) {
    echo PHP_EOL.PHP_EOL.'Listen event "demo_lifecyclableacme:-state1"';
    echo PHP_EOL.'Instance demo\\LifeCyclableAcme outgoing in state 1, hash : '.spl_object_hash($event->getObject());
});

$eventDistpatcher->addListener('demo_lifecyclableacme:-state2', function (EventInterface $event) {
    echo PHP_EOL.PHP_EOL.'Listen event "demo_lifecyclableacme:-state2"';
    echo PHP_EOL.'Instance demo\\LifeCyclableAcme outgoing in state 2, hash : '.spl_object_hash($event->getObject());
});

$eventDistpatcher->addListener('demo_lifecyclableacme:state1', function (EventInterface $event) {
    echo PHP_EOL.PHP_EOL.'Listen event "demo_lifecyclableacme:state1"';
    echo PHP_EOL.'Instance demo\\LifeCyclableAcme in state 1, hash : '.spl_object_hash($event->getObject());
});

$eventDistpatcher->addListener('demo_lifecyclableacme:state2', function (EventInterface $event) {
    echo PHP_EOL.PHP_EOL.'Listen event "demo_lifecyclableacme:state2"';
    echo PHP_EOL.'Instance demo\\LifeCyclableAcme in state 2, hash : '.spl_object_hash($event->getObject());
});

//Create instance to tests
$lifeCyclableAcme = new LifeCyclableAcme();
echo PHP_EOL.PHP_EOL.'Instance not registered, no event';
$lifeCyclableAcme->notifyObserved();

$observer = $generator->getObserver();
$observer->attachObject($lifeCyclableAcme);

echo PHP_EOL.PHP_EOL.'Instance registered, first event';
$lifeCyclableAcme->notifyObserved();
echo PHP_EOL.PHP_EOL.'Instance registered, no change';
$lifeCyclableAcme->notifyObserved();

echo PHP_EOL.PHP_EOL.'Enable State1';
$lifeCyclableAcme->enableState(State1::class);
$lifeCyclableAcme->notifyObserved();

echo PHP_EOL.PHP_EOL.'Enable State2';
$lifeCyclableAcme->enableState(State2::class);
$lifeCyclableAcme->notifyObserved();

echo PHP_EOL.PHP_EOL.'Disable State1';
$lifeCyclableAcme->disableState(State1::class);
$lifeCyclableAcme->notifyObserved();
