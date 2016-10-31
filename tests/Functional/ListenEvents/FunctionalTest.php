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
namespace Teknoo\Tests\States\LifeCycle\Functional\ListenEvents;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\Event\EventDispatcherBridgeInterface;
use Teknoo\States\LifeCycle\Observing\Observed;
use Teknoo\States\LifeCycle\Observing\ObservedFactory;
use Teknoo\States\LifeCycle\Observing\Observer;
use Teknoo\States\LifeCycle\Scenario\Manager;
use Teknoo\States\LifeCycle\Scenario\ScenarioBuilder;
use Teknoo\States\LifeCycle\Tokenization\Tokenizer;
use Teknoo\States\LifeCycle\Trace\Trace;
use Teknoo\Tests\States\LifeCycle\Functional\ListenEvents\ClassA\ClassA;
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
                 * @var EventDispatcher;
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

    public function testListeningEventGlobal()
    {
        $instanceA = $this->getInstanceA();

        $observer = $this->getObserver();
        $observer->attachObject($instanceA);

        $counter = 0;
        $this->getEventDispatcher()->addListener(
            'teknoo_tests_states_lifecycle_functional_listenevents_classa',
            function (EventInterface $event) use (&$counter, $instanceA) {
                self::assertEquals($instanceA, $event->getObject());
                ++$counter;
            }
        );

        $instanceA->switchToState2();
        $instanceA->enableState3();
        $instanceA->switchToState3();

        self::assertEquals(3, $counter);
    }

    public function testListeningEventState()
    {
        $instanceA = $this->getInstanceA();

        $observer = $this->getObserver();
        $observer->attachObject($instanceA);

        $counter = 0;
        $this->getEventDispatcher()->addListener(
            'teknoo_tests_states_lifecycle_functional_listenevents_classa:state2',
            function (EventInterface $event) use (&$counter, $instanceA) {
                self::assertEquals($instanceA, $event->getObject());
                ++$counter;
            }
        );

        $instanceA->switchToState2();
        $instanceA->enableState3();
        $instanceA->switchToState3();

        self::assertEquals(2, $counter);
    }

    public function testListeningEventIncoming()
    {
        $instanceA = $this->getInstanceA();

        $observer = $this->getObserver();
        $observer->attachObject($instanceA);

        $counter = 0;
        $this->getEventDispatcher()->addListener(
            'teknoo_tests_states_lifecycle_functional_listenevents_classa:+state3',
            function (EventInterface $event) use (&$counter, $instanceA) {
                self::assertEquals($instanceA, $event->getObject());
                ++$counter;
            }
        );

        $instanceA->switchToState2();
        $instanceA->enableState3();
        $instanceA->switchToState3();

        self::assertEquals(1, $counter);
    }

    public function testListeningEventOutgoing()
    {
        $instanceA = $this->getInstanceA();

        $observer = $this->getObserver();
        $observer->attachObject($instanceA);

        $counter = 0;
        $this->getEventDispatcher()->addListener(
            'teknoo_tests_states_lifecycle_functional_listenevents_classa:-state2',
            function (EventInterface $event) use (&$counter, $instanceA) {
                self::assertEquals($instanceA, $event->getObject());
                ++$counter;
            }
        );

        $instanceA->switchToState2();
        $instanceA->enableState3();
        $instanceA->switchToState3();

        self::assertEquals(1, $counter);
    }
}
