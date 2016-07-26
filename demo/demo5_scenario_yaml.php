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
use demo\AcmeUpdateStatesDependencies\ClassB\ClassB;
use Gaufrette\Adapter\Local;
use Gaufrette\Filesystem;
use Symfony\Component\Yaml\Parser;
use Teknoo\States\LifeCycle\Generator;
use Teknoo\States\LifeCycle\Scenario\Scenario;
use Teknoo\States\LifeCycle\Scenario\ScenarioYamlBuilder;
use Teknoo\States\Loader\LoaderInterface;

/*
 * @var LoaderInterface
 */
$stateLoader = require_once __DIR__.'/../vendor/teknoo/states/src/bootstrap.php';
$stateLoader->registerNamespace('\\demo', __DIR__);

//Use the helper generator to get needed instance of observer and event dispatcher, it's not a mandatory tool
$generator = new Generator();

//Create the scenario builder
$instanceA = new ClassA();
$instanceB = new ClassB();
$generator->getObserver()->attachObject($instanceA);

$adapter = new Local(__DIR__.'\scenarii');
$filesystem = new Filesystem($adapter);

$parser = new Parser();

//First scenario
$generator->getManager()
    ->registerScenario(
        (new ScenarioYamlBuilder($generator->getTokenizer()))
            ->setYamlParser($parser)
            ->setFilesystem($filesystem)
            ->loadScenario('scenario1.yml')
            ->setParameter('instanceB', $instanceB)
            ->build(new Scenario())
);

//Second scenario
$generator->getManager()
    ->registerScenario(
        (new ScenarioYamlBuilder($generator->getTokenizer()))
            ->setYamlParser($parser)
            ->setFilesystem($filesystem)
            ->loadScenario('scenario2.yml')
            ->setParameter('instanceB', $instanceB)
            ->build(new Scenario())
);

//Third scenario
$generator->getManager()
    ->registerScenario(
        (new ScenarioYamlBuilder($generator->getTokenizer()))
            ->setYamlParser($parser)
            ->setFilesystem($filesystem)
            ->loadScenario('scenario3.yml')
            ->setParameter('instanceB', $instanceB)
            ->build(new Scenario())
);

//Fourth scenario
$generator->getManager()
    ->registerScenario(
        (new ScenarioYamlBuilder($generator->getTokenizer()))
            ->setYamlParser($parser)
            ->setFilesystem($filesystem)
            ->loadScenario('scenario4.yml')
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
