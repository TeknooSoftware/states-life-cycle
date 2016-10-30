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
namespace Teknoo\Tests\States\LifeCycle\Functional\UpdateStatesDependencies;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\Observing\EventDispatcherBridgeInterface;
use Teknoo\States\LifeCycle\Observing\Observed;
use Teknoo\States\LifeCycle\Observing\ObservedFactory;
use Teknoo\States\LifeCycle\Observing\Observer;
use Teknoo\States\LifeCycle\Scenario\Manager;
use Teknoo\States\LifeCycle\Scenario\Scenario;
use Teknoo\States\LifeCycle\Scenario\ScenarioBuilder;
use Teknoo\States\LifeCycle\Tokenization\Tokenizer;
use Teknoo\States\LifeCycle\Trace\Trace;
use Teknoo\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassA\ClassA;
use Teknoo\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassA\States\State2;
use Teknoo\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassA\States\State3;
use Teknoo\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassA\States\StateDefault;
use Teknoo\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassB\ClassB;
use Teknoo\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassB\States\State2 as State2B;
use Teknoo\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassB\States\State3 as State3B;
use Teknoo\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassB\States\StateDefault as StateDefaultB;
use Teknoo\Tests\States\LifeCycle\Support\Event;

/**
 * Class FunctionalTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 * @coversNothing
 */
class FunctionalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EventDispatcherBridgeInterface
     */
    protected $dispatcher;

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * @var Observer
     */
    protected $observer;

    /**
     * @var ClassA
     */
    protected $instanceA;

    /**
     * @var ClassB
     */
    protected $instanceB;

    /**
     * @var Tokenizer
     */
    protected $tokenizer;

    /**
     * @return Tokenizer
     */
    protected function getTokenizer()
    {
        if (!$this->tokenizer instanceof Tokenizer) {
            $this->tokenizer = new Tokenizer();
        }

        return $this->tokenizer;
    }

    /**
     * @return EventDispatcherBridgeInterface
     */
    protected function getEventDispatcher()
    {
        if (!$this->dispatcher instanceof EventDispatcherBridgeInterface) {
            $this->dispatcher = new class(new EventDispatcher()) implements EventDispatcherBridgeInterface {
                /**
                 * @var EventDispatcher
                 */
                private $eventDispatcher;

                /**
                 *  constructor.
                 * @param EventDispatcher $eventDispatcher
                 */
                public function __construct(EventDispatcher $eventDispatcher)
                {
                    $this->eventDispatcher = $eventDispatcher;
                }

                /**
                 * @param string $eventName
                 * @param EventInterface|null $event
                 * @return EventDispatcherBridgeInterface
                 */
                public function dispatch($eventName, EventInterface $event = null): EventDispatcherBridgeInterface
                {
                    $this->eventDispatcher->dispatch($eventName, $event);

                    return $this;
                }

                /**
                 * @param string $eventName
                 * @param callable $listener
                 * @param int $priority
                 * @return EventDispatcherBridgeInterface
                 */
                public function addListener($eventName, $listener, $priority = 0): EventDispatcherBridgeInterface
                {
                    $this->eventDispatcher->addListener($eventName, $listener, $priority);

                    return $this;
                }

                /**
                 * @param string $eventName
                 * @param callable $listener
                 * @return EventDispatcherBridgeInterface
                 */
                public function removeListener($eventName, $listener): EventDispatcherBridgeInterface
                {
                    $this->eventDispatcher->removeListener($eventName, $listener);

                    return $this;
                }
            };
        }

        return $this->dispatcher;
    }

    /**
     * @return Manager
     */
    protected function getManager()
    {
        if (!$this->manager instanceof Manager) {
            $this->manager = new Manager($this->getEventDispatcher());
        }

        return $this->manager;
    }

    /**
     * @return Observer
     */
    protected function getObserver()
    {
        if (!$this->observer instanceof Observer) {
            $observerFactory = new ObservedFactory(
                Observed::class,
                Event::class,
                Trace::class
            );

            $this->observer = new Observer($observerFactory);
            $this->observer->addEventDispatcher($this->getEventDispatcher());
            $this->observer->setTokenizer($this->getTokenizer());
        }

        return $this->observer;
    }

    /**
     * @return ScenarioBuilder
     */
    protected function createNewScenarioBuilder()
    {
        return new ScenarioBuilder($this->getTokenizer());
    }

    /**
     * @return ClassA
     */
    protected function getInstanceA()
    {
        if (!$this->instanceA instanceof ClassA) {
            $this->instanceA = new ClassA();
        }

        return $this->instanceA;
    }

    /**
     * @return ClassB
     */
    protected function getInstanceB()
    {
        if (!$this->instanceB instanceof ClassB) {
            $this->instanceB = new ClassB();
        }

        return $this->instanceB;
    }

    /**
     * @return $this
     */
    protected function prepareScenarioA()
    {
        $scenarioBuilder = $this->createNewScenarioBuilder()
            ->towardStatedClass('Teknoo\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassA')
            ->onIncomingState(State2:: class)
            ->run(function () {
                $this->getInstanceB()->switchToState2();
            });

        $this->getManager()->registerScenario($scenarioBuilder->build(new Scenario()));

        return $this;
    }

    /**
     * @return $this
     */
    protected function prepareScenarioB()
    {
        $scenarioBuilder = $this->createNewScenarioBuilder()
            ->towardStatedClass('Teknoo\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassA')
            ->onIncomingState(State3::class)
            ->ifInState(State2::class)
            ->run(function () {
                $this->getInstanceB()->switchToState1();
            });

        $this->getManager()->registerScenario($scenarioBuilder->build(new Scenario()));

        return $this;
    }

    /**
     * @return $this
     */
    protected function prepareScenarioC()
    {
        $scenarioBuilder = $this->createNewScenarioBuilder()
            ->towardStatedClass('Teknoo\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassA')
            ->onIncomingState(State3::class)
            ->onOutgoingState(State2::class)
            ->ifNotInState(StateDefault::class)
            ->run(function () {
                $this->getInstanceB()->switchToState3();
            });

        $this->getManager()->registerScenario($scenarioBuilder->build(new Scenario()));

        return $this;
    }

    /**
     * @return $this
     */
    protected function prepareScenarioD()
    {
        $scenarioBuilder = $this->createNewScenarioBuilder()
            ->towardStatedClass('Teknoo\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassE')
            ->onIncomingState(State3::class)
            ->onOutgoingState(State2::class)
            ->ifNotInState(StateDefault::class)
            ->run(function () {
                $this->getInstanceB()->switchToState1();
            });

        $this->getManager()->registerScenario($scenarioBuilder->build(new Scenario()));

        return $this;
    }

    public function testCaseWithoutRegisteredScenario()
    {
        $instanceA = $this->getInstanceA();
        $instanceB = $this->getInstanceB();

        $observer = $this->getObserver();
        $observer->attachObject($instanceA);
        $observer->attachObject($instanceB);

        $this->assertEquals([StateDefault::class], $instanceA->listEnabledStates());
        $this->assertEquals([StateDefaultB::class], $instanceB->listEnabledStates());

        $instanceA->switchToState2();

        $this->assertEquals([State2::class], $instanceA->listEnabledStates());
        $this->assertEquals([StateDefaultB::class], $instanceB->listEnabledStates());

        $instanceA->enableState3();

        $this->assertEquals([State2::class, State3::class], $instanceA->listEnabledStates());
        $this->assertEquals([StateDefaultB::class], $instanceB->listEnabledStates());

        $instanceA->switchToState3();

        $this->assertEquals([State3::class], $instanceA->listEnabledStates());
        $this->assertEquals([StateDefaultB::class], $instanceB->listEnabledStates());
    }

    public function testCaseWithRegisteredScenario()
    {
        $instanceA = $this->getInstanceA();
        $instanceB = $this->getInstanceB();

        $observer = $this->getObserver();
        $observer->attachObject($instanceA);
        $observer->attachObject($instanceB);

        $this->prepareScenarioA();
        $this->prepareScenarioB();
        $this->prepareScenarioC();
        $this->prepareScenarioD();

        $this->assertEquals([StateDefault::class], $instanceA->listEnabledStates());
        $this->assertEquals([StateDefaultB::class], $instanceB->listEnabledStates());

        $instanceA->switchToState2();

        $this->assertEquals([State2::class], $instanceA->listEnabledStates());
        $this->assertEquals([State2B::class], $instanceB->listEnabledStates());

        $instanceA->enableState3();

        $this->assertEquals([State2::class, State3::class], $instanceA->listEnabledStates());
        $this->assertEquals([StateDefaultB::class], $instanceB->listEnabledStates());

        $instanceA->switchToState1()->switchToState2();
        $instanceA->switchToState3();

        $this->assertEquals([State3::class], $instanceA->listEnabledStates());
        $this->assertEquals([State3B::class], $instanceB->listEnabledStates());
    }

    public function testCaseWithRegisteredScenarioAndDetach()
    {
        $instanceA = $this->getInstanceA();
        $instanceB = $this->getInstanceB();

        $observer = $this->getObserver();
        $observer->attachObject($instanceA);
        $observer->attachObject($instanceB);

        $this->prepareScenarioA();
        $this->prepareScenarioB();
        $this->prepareScenarioC();
        $this->prepareScenarioD();

        $this->assertEquals([StateDefault::class], $instanceA->listEnabledStates());
        $this->assertEquals([StateDefaultB::class], $instanceB->listEnabledStates());

        $instanceA->switchToState2();

        $this->assertEquals([State2::class], $instanceA->listEnabledStates());
        $this->assertEquals([State2B::class], $instanceB->listEnabledStates());

        $observer->detachObject($instanceA);
        $instanceA->enableState3();

        $this->assertEquals([State2::class, State3::class], $instanceA->listEnabledStates());
        $this->assertEquals([State2B::class], $instanceB->listEnabledStates());

        $instanceA->switchToState1()->switchToState2();
        $instanceA->switchToState3();

        $this->assertEquals([State3::class], $instanceA->listEnabledStates());
        $this->assertEquals([State2B::class], $instanceB->listEnabledStates());
    }

    public function testCaseWithRegisteredScenarioAndDetachObserved()
    {
        $instanceA = $this->getInstanceA();
        $instanceB = $this->getInstanceB();

        $observer = $this->getObserver();
        $observer->attachObject($instanceA);
        $observer->attachObject($instanceB);

        $this->prepareScenarioA();
        $this->prepareScenarioB();
        $this->prepareScenarioC();
        $this->prepareScenarioD();

        $this->assertEquals([StateDefault::class], $instanceA->listEnabledStates());
        $this->assertEquals([StateDefaultB::class], $instanceB->listEnabledStates());

        $instanceA->switchToState2();

        $this->assertEquals([State2::class], $instanceA->listEnabledStates());
        $this->assertEquals([State2B::class], $instanceB->listEnabledStates());

        $observer->detachObject($instanceB);
        $instanceA->enableState3();

        $this->assertEquals([State2::class, State3::class], $instanceA->listEnabledStates());
        $this->assertEquals([StateDefaultB::class], $instanceB->listEnabledStates());

        $instanceA->switchToState1()->switchToState2();
        $instanceA->switchToState3();

        $this->assertEquals([State3::class], $instanceA->listEnabledStates());
        $this->assertEquals([State3B::class], $instanceB->listEnabledStates());
    }
}
