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

namespace Teknoo\Tests\States\LifeCycle;

use DI\Container;
use Gaufrette\Adapter;
use Teknoo\States\LifeCycle\Event\EventDispatcherBridgeInterface;
use Teknoo\States\LifeCycle\Event\Symfony\EventDispatcherBridge;
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

/**
 * Class ContainerTest.
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class ContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Container
     */
    protected function buildContainer() : Container
    {
        return include(__DIR__.'/../src/generator.php');
    }

    public function testGetTokenizer()
    {
        $container = $this->buildContainer();
        $tokenizer1 = $container->get(TokenizerInterface::class);
        $tokenizer2 = $container->get(Tokenizer::class);
        self::assertInstanceOf(TokenizerInterface::class, $tokenizer1);
        self::assertSame($tokenizer1, $tokenizer2);
    }

    public function testGetEventDispatcherBridge()
    {
        $container = $this->buildContainer();
        $eventDispatcherBridge1 = $container->get(EventDispatcherBridgeInterface::class);
        $eventDispatcherBridge2 = $container->get(EventDispatcherBridge::class);
        self::assertInstanceOf(EventDispatcherBridgeInterface::class, $eventDispatcherBridge1);
        self::assertSame($eventDispatcherBridge1, $eventDispatcherBridge2);
    }

    public function testGetManager()
    {
        $container = $this->buildContainer();
        $manager1 = $container->get(ManagerInterface::class);
        $manager2 = $container->get(Manager::class);
        self::assertInstanceOf(ManagerInterface::class, $manager1);
        self::assertSame($manager1, $manager2);
    }

    public function testGetObserver()
    {
        $container = $this->buildContainer();
        $observer1 = $container->get(ObserverInterface::class);
        $observer2 = $container->get(Observer::class);
        self::assertInstanceOf(ObserverInterface::class, $observer1);
        self::assertSame($observer1, $observer2);
    }

    public function testGetObservedFactory()
    {
        $container = $this->buildContainer();
        $observedFactory1 = $container->get(ObservedFactoryInterface::class);
        $observedFactory2 = $container->get(ObservedFactory::class);
        self::assertInstanceOf(ObservedFactoryInterface::class, $observedFactory1);
        self::assertSame($observedFactory1, $observedFactory2);
    }

    public function testGetScenarioBuilder()
    {
        $container = $this->buildContainer();
        $scenarioBuilder1 = $container->get(ScenarioBuilderInterface::class);
        $scenarioBuilder2 = $container->get(ScenarioBuilder::class);
        self::assertInstanceOf(ScenarioBuilderInterface::class, $scenarioBuilder1());
        self::assertNotSame($scenarioBuilder1(), $scenarioBuilder2());
    }

    public function testGetScenarioYamlBuilder()
    {
        $container = $this->buildContainer();
        $container->set(Adapter::class, new Adapter\Local(__DIR__));
        $scenarioYamlBuilder1 = $container->get(ScenarioBuilderInterface::class);
        $scenarioYamlBuilder2 = $container->get(ScenarioYamlBuilder::class);
        self::assertInstanceOf(ScenarioBuilderInterface::class, $scenarioYamlBuilder1());
        self::assertNotSame($scenarioYamlBuilder1(), $scenarioYamlBuilder2());
    }

    public function testGetScenario()
    {
        $container = $this->buildContainer();
        $scenario1 = $container->get(ScenarioInterface::class);
        $scenario2 = $container->get(Scenario::class);
        self::assertInstanceOf(ScenarioInterface::class, $scenario1());
        self::assertNotSame($scenario1(), $scenario2());
    }
}
