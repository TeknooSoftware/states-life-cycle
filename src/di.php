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

namespace Teknoo\States\LifeCycle;

use function DI\get;
use Gaufrette\Filesystem;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Yaml\Parser;
use Teknoo\States\LifeCycle\Event\EventDispatcherBridgeInterface;
use Teknoo\States\LifeCycle\Event\Symfony\Event;
use Teknoo\States\LifeCycle\Event\Symfony\EventDispatcherBridge;
use Teknoo\States\LifeCycle\Observing\Observed;
use Teknoo\States\LifeCycle\Observing\ObservedFactory;
use Teknoo\States\LifeCycle\Observing\ObservedFactoryInterface;
use Teknoo\States\LifeCycle\Observing\Observer;
use Teknoo\States\LifeCycle\Observing\ObserverInterface;
use Teknoo\States\LifeCycle\Scenario\Manager;
use Teknoo\States\LifeCycle\Scenario\ManagerInterface;
use Teknoo\States\LifeCycle\Scenario\Scenario;
use Teknoo\States\LifeCycle\Scenario\ScenarioBuilder;
use Teknoo\States\LifeCycle\Scenario\ScenarioBuilderInterface;
use Teknoo\States\LifeCycle\Scenario\ScenarioInterface;
use Teknoo\States\LifeCycle\Scenario\ScenarioYamlBuilder;
use Teknoo\States\LifeCycle\Tokenization\Tokenizer;
use Teknoo\States\LifeCycle\Tokenization\TokenizerInterface;
use Teknoo\States\LifeCycle\Trace\Trace;

return [
    //Tokenizer
    Tokenizer::class => function (): TokenizerInterface {
        return new Tokenizer();
    },
    TokenizerInterface::class => get(Tokenizer::class),

    //Event dispatcher
    EventDispatcherBridge::class => function (EventDispatcher $eventDispatcher): EventDispatcherBridgeInterface {
        return new EventDispatcherBridge($eventDispatcher);
    },
    EventDispatcherBridgeInterface::class => get(EventDispatcherBridge::class),

    //Manager
    Manager::class => function (EventDispatcherBridgeInterface $bridge): ManagerInterface {
        return new Manager($bridge);
    },
    ManagerInterface::class => get(Manager::class),

    //Observed factory
    ObservedFactory::class => function (): ObservedFactoryInterface {
        return new ObservedFactory(
            Observed::class,
            Event::class,
            Trace::class
        );
    },
    ObservedFactoryInterface::class => get(ObservedFactory::class),

    //observer
    Observer::class => function (
        ObservedFactoryInterface $factory,
        EventDispatcherBridgeInterface $bridge,
        TokenizerInterface $tokenizer
    ): ObserverInterface {

        $observer = new Observer($factory);
        $observer->addEventDispatcher($bridge);
        $observer->setTokenizer($tokenizer);
    
        return $observer;
    },
    ObserverInterface::class => get(Observer::class),

    //Scenario builder generator
    ScenarioBuilder::class => function(Tokenizer $tokenizer) {
        return function () use ($tokenizer) {
            return new ScenarioBuilder($tokenizer);
        };
    },
    ScenarioBuilderInterface::class => get(ScenarioBuilder::class),

    //Scenario yaml builder generator
    ScenarioYamlBuilder::class => function (Tokenizer $tokenizer, Parser $parser, Filesystem $filesystem) {
        return function () use ($tokenizer, $parser, $filesystem) {
            return (new ScenarioYamlBuilder($tokenizer))
                ->setYamlParser($parser)
                ->setFilesystem($filesystem);
        };
    },

    //Scenario builder
    Scenario::class => function () {
        return function () {
            return new Scenario();
        };
    },
    ScenarioInterface::class => get(Scenario::class),
];