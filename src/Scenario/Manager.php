<?php

declare(strict_types=1);

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

namespace Teknoo\States\LifeCycle\Scenario;

use Teknoo\States\LifeCycle\Event\EventDispatcherBridgeInterface;

/**
 * Class Manager
 * Interface to manage to store all enabled scenarii and register them into the event dispatcher.
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class Manager implements ManagerInterface
{
    /**
     * Current enabled scenari.
     *
     * @var ScenarioInterface[]
     */
    private $scenariiList = [];

    /**
     * Dispatcher used to register scenarii.
     *
     * @var EventDispatcherBridgeInterface
     */
    private $dispatcher;

    /**
     * @param EventDispatcherBridgeInterface $dispatcher
     */
    public function __construct(EventDispatcherBridgeInterface $dispatcher)
    {
        $this->setDispatcher($dispatcher);
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function setDispatcher(EventDispatcherBridgeInterface $dispatcher): ManagerInterface
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    /**
     * @param ScenarioInterface $scenario
     *
     * @return $this
     */
    private function addEventsAboutScenario(ScenarioInterface $scenario)
    {
        $dispatcher = $this->getDispatcher();
        foreach ($scenario->getEventsNamesList() as $eventName) {
            $dispatcher->addListener($eventName, $scenario);
        }

        return $this;
    }

    /**
     * @param ScenarioInterface $scenario
     *
     * @return $this
     */
    private function removeEventsAboutScenario(ScenarioInterface $scenario)
    {
        $dispatcher = $this->getDispatcher();
        foreach ($scenario->getEventsNamesList() as $eventName) {
            $dispatcher->removeListener($eventName, $scenario);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function registerScenario(ScenarioInterface $scenario): ManagerInterface
    {
        $scenarioHash = \spl_object_hash($scenario);

        if (!isset($this->scenariiList[$scenarioHash])) {
            $this->scenariiList[$scenarioHash] = $scenario;
            $this->addEventsAboutScenario($scenario);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function unregisterScenario(ScenarioInterface $scenario): ManagerInterface
    {
        $scenarioHash = \spl_object_hash($scenario);

        if (isset($this->scenariiList[$scenarioHash])) {
            $this->removeEventsAboutScenario($scenario);
            unset($this->scenariiList[$scenarioHash]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function listScenarii(): array
    {
        return $this->scenariiList;
    }
}
