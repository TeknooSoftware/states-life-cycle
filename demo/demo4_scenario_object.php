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

use demo\AcmeUpdateStatesDependencies\ClassA\ClassA;
use demo\AcmeUpdateStatesDependencies\ClassA\States\State2;
use demo\AcmeUpdateStatesDependencies\ClassA\States\State3;
use demo\AcmeUpdateStatesDependencies\ClassA\States\StateDefault;
use demo\AcmeUpdateStatesDependencies\ClassB\ClassB;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Teknoo\States\LifeCycle\Generator;
use Teknoo\States\LifeCycle\Scenario\Scenario;
use Teknoo\States\LifeCycle\Scenario\ScenarioBuilder;

include dirname(__DIR__).'/vendor/autoload.php';

//Use the helper generator to get needed instance of observer and event dispatcher, it's not a mandatory tool
$generator = new Generator();
$generator->setEventClassName(Event::class);
$generator->setEventDispatcher(new EventDispatcherBridge(new EventDispatcher()));

//Create the scenario builder
$instanceA = new ClassA();
$instanceB = new ClassB();
$generator->getObserver()->attachObject($instanceA);

//First scenario
$generator->getManager()
    ->registerScenario(
        (new ScenarioBuilder($generator->getTokenizer()))
        ->towardStatedClass('demo\AcmeUpdateStatesDependencies\ClassA')
        ->onIncomingState(State2::class)
        ->run(function () use ($instanceB) {
            $instanceB->switchToState2();
        })
        ->build(new Scenario())
);

//Second scenario
$generator->getManager()
    ->registerScenario(
        (new ScenarioBuilder($generator->getTokenizer()))
        ->towardStatedClass('demo\AcmeUpdateStatesDependencies\ClassA')
        ->onIncomingState(State3::class)
        ->ifInState(State2::class)
        ->run(function () use ($instanceB) {
            $instanceB->switchToStateDefault();
        })
        ->build(new Scenario())
);

//Third scenario
$generator->getManager()
    ->registerScenario(
        (new ScenarioBuilder($generator->getTokenizer()))
        ->towardStatedClass('demo\AcmeUpdateStatesDependencies\ClassA')
        ->onIncomingState(State3::class)
        ->onOutgoingState(State2::class)
        ->ifNotInState(StateDefault::class)
        ->run(function () use ($instanceB) {
            $instanceB->switchToState3();
        })
        ->build(new Scenario())
);

//Fourth scenario
$generator->getManager()
    ->registerScenario(
        (new ScenarioBuilder($generator->getTokenizer()))
        ->towardStatedClass('demo\NonExistant\Class')
        ->onIncomingState('State3')
        ->onOutgoingState('State2')
        ->ifNotInState('StateDefault')
        ->run(function () use ($instanceB) {
            $instanceB->switchToStateDefault();
        })
        ->build(new Scenario())
);

echo PHP_EOL.'Start the demo, two instance have only default state enabled';
echo PHP_EOL.'Instance A - Enabled states : '.implode(', ', $instanceA->listEnabledStates());
echo PHP_EOL.'Instance B - Enabled states : '.implode(', ', $instanceB->listEnabledStates());

echo PHP_EOL.PHP_EOL.'Switch to State 2 only for the instance A, instance B will be switched to State 2, like described in scenario 1';
$instanceA->switchToState2();
echo PHP_EOL.'Instance A - Enabled states : '.implode(', ', $instanceA->listEnabledStates());
echo PHP_EOL.'Instance B - Enabled states : '.implode(', ', $instanceB->listEnabledStates());

echo PHP_EOL.PHP_EOL.'Enable to State 3 only for the instance A, instance B will be back to state default, like described in scenario 2';
$instanceA->enableState3();
echo PHP_EOL.'Instance A - Enabled states : '.implode(', ', $instanceA->listEnabledStates());
echo PHP_EOL.'Instance B - Enabled states : '.implode(', ', $instanceB->listEnabledStates());

echo PHP_EOL.PHP_EOL.'Switch to State 1 then 2 only for the instance A, instance B will be switch to 3 also, like described in scenario 1 and 3';
$instanceA->switchToStateDefault()->switchToState2();
$instanceA->switchToState3();
echo PHP_EOL.'Instance A - Enabled states : '.implode(', ', $instanceA->listEnabledStates());
echo PHP_EOL.'Instance B - Enabled states : '.implode(', ', $instanceB->listEnabledStates());
