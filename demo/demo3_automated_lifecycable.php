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
namespace demo;

use demo\AutomatedLifeCyclableAcme\AutomatedLifeCyclableAcme;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\Generator;

include dirname(__DIR__).'/vendor/autoload.php';

//Use the helper generator to get needed instance of observer and event dispatcher, it's not a mandatory tool
$generator = new Generator();
$generator->setEventClassName(Event::class);
$generator->setEventDispatcher(new EventDispatcherBridge(new EventDispatcher()));
$eventDistpatcher = $generator->getEventDispatcher();

$eventDistpatcher->addListener('demo_automatedlifecyclableacme', function (EventInterface $event) {
    echo PHP_EOL.PHP_EOL.'Listen event "demo_automatedlifecyclableacme"';
    echo PHP_EOL.'New event from an instance demo\\LifeCyclableAcme, hash : '.spl_object_hash($event->getObject());
    echo PHP_EOL.'Enabled states : '.implode(', ', $event->getEnabledStates());
    echo PHP_EOL.'Incoming states : '.implode(', ', $event->getIncomingStates());
    echo PHP_EOL.'Outgoing states : '.implode(', ', $event->getOutgoingStates());
});

$eventDistpatcher->addListener('demo_automatedlifecyclableacme:+state1', function (EventInterface $event) {
    echo PHP_EOL.PHP_EOL.'Listen event "demo_automatedlifecyclableacme:+state1"';
    echo PHP_EOL.'Instance demo\\LifeCyclableAcme incoming in state 1, hash : '.spl_object_hash($event->getObject());
});

$eventDistpatcher->addListener('demo_automatedlifecyclableacme:-state2', function (EventInterface $event) {
    echo PHP_EOL.PHP_EOL.'Listen event "demo_automatedlifecyclableacme:-state2"';
    echo PHP_EOL.'Instance demo\\LifeCyclableAcme outgoing in state 2, hash : '.spl_object_hash($event->getObject());
});

$eventDistpatcher->addListener('demo_automatedlifecyclableacme:state2', function (EventInterface $event) {
    echo PHP_EOL.PHP_EOL.'Listen event "demo_automatedlifecyclableacme:state2"';
    echo PHP_EOL.'Instance demo\\LifeCyclableAcme in state 2, hash : '.spl_object_hash($event->getObject());
});

echo PHP_EOL.'Create new automated and lifecyclable instance and attach it to the observer';
$automatedLifeCyclable = new AutomatedLifeCyclableAcme();
$generator->getObserver()->attachObject($automatedLifeCyclable);

echo PHP_EOL.'No enabled states :';
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedLifeCyclable->listEnabledStates());

echo PHP_EOL.'Set foo property at bar, not call updateStates, states must stay unchanged';
$automatedLifeCyclable->setFoo('bar');
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedLifeCyclable->listEnabledStates());
echo PHP_EOL.'Call updateStates, change states, enable state 1';
$automatedLifeCyclable->updateStates();
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedLifeCyclable->listEnabledStates());

echo PHP_EOL.'Set foo1 property at bar1, not call updateStates, states must stay unchanged';
$automatedLifeCyclable->setFoo1('bar1')->setFoo2(123);
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedLifeCyclable->listEnabledStates());
echo PHP_EOL.'Call updateStates, change states, state1 must stay enabled';
$automatedLifeCyclable->updateStates();
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedLifeCyclable->listEnabledStates());

echo PHP_EOL.'Set foo1 property at bar1 and foo2 to null, not call updateStates, states must stay unchanged';
$automatedLifeCyclable->setFoo1('bar1')->setFoo2(null);
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedLifeCyclable->listEnabledStates());
$automatedLifeCyclable->updateStates();
echo PHP_EOL.'Call updateStates, change states, state1 must stay enabled, state 2 must be enabled';
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedLifeCyclable->listEnabledStates());

echo PHP_EOL.'Set foo property at empty, not call updateStates, states must stay unchanged';
$automatedLifeCyclable->setFoo('');
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedLifeCyclable->listEnabledStates());
$automatedLifeCyclable->updateStates();
echo PHP_EOL.'Call updateStates, change states, state1 must be disabled';
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedLifeCyclable->listEnabledStates());

echo PHP_EOL.'Set foo1 property at empty, not call updateStates, states must stay unchanged';
$automatedLifeCyclable->setFoo1('');
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedLifeCyclable->listEnabledStates());
$automatedLifeCyclable->updateStates();
echo PHP_EOL.'Call updateStates, change states, all states are disabled';
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedLifeCyclable->listEnabledStates());
