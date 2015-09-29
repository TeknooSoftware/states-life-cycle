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
 * to contact@uni-alteri.com so we can send you a copy immediately.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\Tests\States\LifeCycle\Functional\UpdateStatesDependencies;

use Symfony\Component\EventDispatcher\EventDispatcher;
use UniAlteri\States\LifeCycle\Observing\Observer;
use UniAlteri\States\LifeCycle\Scenario\Manager;
use UniAlteri\States\LifeCycle\Scenario\ScenarioBuilder;
use UniAlteri\States\LifeCycle\Tokenization\Tokenizer;
use UniAlteri\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassA\ClassA;
use UniAlteri\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassB\ClassB;

/**
 * Class FunctionalTest
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class FunctionalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EventDispatcher
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
     * @return EventDispatcher
     */
    protected function getEventDispatcher()
    {
        if (!$this->dispatcher instanceof EventDispatcher) {
            $this->dispatcher = new EventDispatcher();
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
            $this->observer = new Observer();
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
            ->towardStatedClass('UniAlteri\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassA')
            ->onIncomingState('State2')
            ->run(function () {
                $this->getInstanceB()->switchToState2();
            });

        $this->getManager()->registerScenario($scenarioBuilder->build());

        return $this;
    }

    /**
     * @return $this
     */
    protected function prepareScenarioB()
    {
        $scenarioBuilder = $this->createNewScenarioBuilder()
            ->towardStatedClass('UniAlteri\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassA')
            ->onIncomingState('State3')
            ->ifInState('State2')
            ->run(function () {
                $this->getInstanceB()->switchToState1();
            });

        $this->getManager()->registerScenario($scenarioBuilder->build());

        return $this;
    }

    /**
     * @return $this
     */
    protected function prepareScenarioC()
    {
        $scenarioBuilder = $this->createNewScenarioBuilder()
            ->towardStatedClass('UniAlteri\Tests\States\LifeCycle\Functional\UpdateStatesDependencies\ClassA')
            ->onIncomingState('State3')
            ->onOutgoingState('State2')
            ->ifNotInState('StateDefault')
            ->run(function () {
                $this->getInstanceB()->switchToState3();
            });

        $this->getManager()->registerScenario($scenarioBuilder->build());

        return $this;
    }

    public function testCaseWithoutRegisteredScenario()
    {
        $instanceA = $this->getInstanceA();
        $instanceB = $this->getInstanceB();

        $observer = $this->getObserver();
        $observer->attachObject($instanceA);
        $observer->attachObject($instanceB);

        $this->assertEquals(['StateDefault'], $instanceA->listEnabledStates());
        $this->assertEquals(['StateDefault'], $instanceB->listEnabledStates());

        $instanceA->switchToState2();

        $this->assertEquals(['State2'], $instanceA->listEnabledStates());
        $this->assertEquals(['StateDefault'], $instanceB->listEnabledStates());

        $instanceA->enableState3();

        $this->assertEquals(['State2', 'State3'], $instanceA->listEnabledStates());
        $this->assertEquals(['StateDefault'], $instanceB->listEnabledStates());

        $instanceA->switchToState3();

        $this->assertEquals(['State3'], $instanceA->listEnabledStates());
        $this->assertEquals(['StateDefault'], $instanceB->listEnabledStates());
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

        $this->assertEquals(['StateDefault'], $instanceA->listEnabledStates());
        $this->assertEquals(['StateDefault'], $instanceB->listEnabledStates());

        $instanceA->switchToState2();

        $this->assertEquals(['State2'], $instanceA->listEnabledStates());
        $this->assertEquals(['State2'], $instanceB->listEnabledStates());

        $instanceA->enableState3();

        $this->assertEquals(['State2', 'State3'], $instanceA->listEnabledStates());
        $this->assertEquals(['StateDefault'], $instanceB->listEnabledStates());

        $instanceA->switchToState1()->switchToState2();
        $instanceA->switchToState3();

        $this->assertEquals(['State3'], $instanceA->listEnabledStates());
        $this->assertEquals(['State3'], $instanceB->listEnabledStates());
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

        $this->assertEquals(['StateDefault'], $instanceA->listEnabledStates());
        $this->assertEquals(['StateDefault'], $instanceB->listEnabledStates());

        $instanceA->switchToState2();

        $this->assertEquals(['State2'], $instanceA->listEnabledStates());
        $this->assertEquals(['State2'], $instanceB->listEnabledStates());

        $observer->detachObject($instanceA);
        $instanceA->enableState3();

        $this->assertEquals(['State2', 'State3'], $instanceA->listEnabledStates());
        $this->assertEquals(['State2'], $instanceB->listEnabledStates());

        $instanceA->switchToState1()->switchToState2();
        $instanceA->switchToState3();

        $this->assertEquals(['State3'], $instanceA->listEnabledStates());
        $this->assertEquals(['State2'], $instanceB->listEnabledStates());
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

        $this->assertEquals(['StateDefault'], $instanceA->listEnabledStates());
        $this->assertEquals(['StateDefault'], $instanceB->listEnabledStates());

        $instanceA->switchToState2();

        $this->assertEquals(['State2'], $instanceA->listEnabledStates());
        $this->assertEquals(['State2'], $instanceB->listEnabledStates());

        $observer->detachObject($instanceB);
        $instanceA->enableState3();

        $this->assertEquals(['State2', 'State3'], $instanceA->listEnabledStates());
        $this->assertEquals(['StateDefault'], $instanceB->listEnabledStates());

        $instanceA->switchToState1()->switchToState2();
        $instanceA->switchToState3();

        $this->assertEquals(['State3'], $instanceA->listEnabledStates());
        $this->assertEquals(['State3'], $instanceB->listEnabledStates());
    }
}