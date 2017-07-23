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

use demo\AcmeUpdateStatesDependencies\ClassA\ClassA;
use demo\AcmeUpdateStatesDependencies\ClassB\ClassB;
use Gaufrette\Adapter\Local;
use Gaufrette\Filesystem;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Yaml\Parser;
use Teknoo\States\LifeCycle\Generator;
use Teknoo\States\LifeCycle\Observing\ObserverInterface;
use Teknoo\States\LifeCycle\Scenario\ManagerInterface;
use Teknoo\States\LifeCycle\Scenario\Scenario;
use Teknoo\States\LifeCycle\Scenario\ScenarioYamlBuilder;
use Teknoo\States\LifeCycle\Tokenization\TokenizerInterface;

include dirname(__DIR__).'/vendor/autoload.php';

//Use the helper generator to get needed instance of observer and event dispatcher, it's not a mandatory tool
$di = include __DIR__.'/../src/generator.php';

//Create the scenario builder
$instanceA = new ClassA();
$instanceB = new ClassB();
$di->get(ObserverInterface::class)->attachObject($instanceA);

$parser = new Parser();

//First scenario
$di->get(ManagerInterface::class)
    ->registerScenario(
        (new ScenarioYamlBuilder($di->get(TokenizerInterface::class)))
            ->setYamlParser($parser)
            ->loadScenario(\file_get_contents(__DIR__.'/scenarii/scenario1.yml'))
            ->setParameter('instanceB', $instanceB)
            ->build(new Scenario())
);

//Second scenario
$di->get(ManagerInterface::class)
    ->registerScenario(
        (new ScenarioYamlBuilder($di->get(TokenizerInterface::class)))
            ->setYamlParser($parser)
            ->loadScenario(\file_get_contents(__DIR__.'/scenarii/scenario2.yml'))
            ->setParameter('instanceB', $instanceB)
            ->build(new Scenario())
);

//Third scenario
$di->get(ManagerInterface::class)
    ->registerScenario(
        (new ScenarioYamlBuilder($di->get(TokenizerInterface::class)))
            ->setYamlParser($parser)
            ->loadScenario(\file_get_contents(__DIR__.'/scenarii/scenario3.yml'))
            ->setParameter('instanceB', $instanceB)
            ->build(new Scenario())
);

//Fourth scenario
$di->get(ManagerInterface::class)
    ->registerScenario(
        (new ScenarioYamlBuilder($di->get(TokenizerInterface::class)))
            ->setYamlParser($parser)
            ->loadScenario(\file_get_contents(__DIR__.'/scenarii/scenario4.yml'))
            ->setParameter('instanceB', $instanceB)
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
