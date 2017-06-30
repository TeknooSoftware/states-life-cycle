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

use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
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
use Teknoo\States\LifeCycle\Tokenization\Tokenizer;
use Teknoo\States\LifeCycle\Tokenization\TokenizerInterface;
use Teknoo\States\LifeCycle\Trace\Trace;

return [
    TokenizerInterface::class => function (): TokenizerInterface {
        return new Tokenizer();
    },

    EventDispatcherBridgeInterface::class => function (ContainerInterface $container): EventDispatcherBridgeInterface {
        return new EventDispatcherBridge($container->get(EventDispatcher::class));
    },

    ManagerInterface::class => function (ContainerInterface $container): ManagerInterface {
        return new Manager($container->get(EventDispatcherBridgeInterface::class));
    },

    ObservedFactoryInterface::class => function (): ObservedFactoryInterface {
        return new ObservedFactory(
            Observed::class,
            Event::class,
            Trace::class
        );
    },

    ObserverInterface::class => function (ContainerInterface $container): ObserverInterface {
        $observer = new Observer($container->get(ObservedFactoryInterface::class));
        $observer->addEventDispatcher($container->get(EventDispatcherBridgeInterface::class));
        $observer->setTokenizer($container->get(TokenizerInterface::class));
    
        return $observer;
    },
];