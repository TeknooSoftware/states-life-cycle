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
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace Teknoo\States\LifeCycle\Scenario;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class Manager
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class Manager implements ManagerInterface
{
    /**
     * @var ScenarioInterface[]|\ArrayAccess
     */
    private $scenariiList = [];

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
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
    public function setDispatcher(EventDispatcherInterface $dispatcher): ManagerInterface
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    /**
     * @param ScenarioInterface $scenario
     * @return $this
     */
    protected function addEventsAboutScenario(ScenarioInterface $scenario)
    {
        $dispatcher = $this->getDispatcher();
        foreach ($scenario->getEventsNamesList() as $eventName) {
            $dispatcher->addListener($eventName, $scenario);
        }

        return $this;
    }

    /**
     * @param ScenarioInterface $scenario
     * @return $this
     */
    protected function removeEventsAboutScenario(ScenarioInterface $scenario)
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
        $scenarioHash = spl_object_hash($scenario);

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
        $scenarioHash = spl_object_hash($scenario);

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