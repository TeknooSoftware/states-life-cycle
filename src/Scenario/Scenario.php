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

namespace UniAlteri\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Event\EventInterface;
use UniAlteri\States\LifeCycle\Observing\ObservedInterface;
use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;

/**
 * Class Scenario
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class Scenario implements ScenarioInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @var string[]
     */
    private $eventsNamesList;

    /**
     * @var string[]
     */
    private $neededIncomingStatesList;

    /**
     * @var string[]
     */
    private $neededOutgoingStatesList;

    /**
     * @var string[]
     */
    private $neededStatesList;

    /**
     * @var string[]
     */
    private $forbiddenStatesList;

    /**
     * @var string
     */
    private $neededStatedClassName;

    /**
     * @var ObservedInterface
     */
    private $neededStatedObject;

    /**
     * @param ScenarioBuilder $scenarioBuilder
     */
    public function __construct(ScenarioBuilder $scenarioBuilder)
    {
        $this->eventsNamesList = $scenarioBuilder->getEventNamesList();
        $this->neededIncomingStatesList = $scenarioBuilder->getNeededIncomingStatesList();
        $this->neededOutgoingStatesList = $scenarioBuilder->getNeededOutgoingStatesList();
        $this->neededStatesList = $scenarioBuilder->getNeededStatesList();
        $this->forbiddenStatesList = $scenarioBuilder->getForbiddenStatesList();
        $this->neededStatedClassName = $scenarioBuilder->getStatedClassName();
        $this->neededStatedObject = $scenarioBuilder->getObserved();
        $this->callback = $scenarioBuilder->getCallable();
    }

    /**
     * {@inheritdoc}
     */
    public function getEventsNamesList(): array
    {
        return $this->eventsNamesList;
    }

    /**
     * @return string[]
     */
    public function listNeededIncomingStates(): array
    {
        return $this->neededIncomingStatesList;
    }

    /**
     * @param EventInterface $event
     * @return bool
     */
    protected function checkNeededIncomingStates(EventInterface $event): \bool
    {
        $neededIncomingStatesList = $this->listNeededIncomingStates();
        if (empty($neededIncomingStatesList)) {
            return true;
        }

        $incomingStateList = $event->getIncomingStates();
        return empty(array_diff($neededIncomingStatesList, $incomingStateList));
    }

    /**
     * @return string[]
     */
    public function listNeededOutgoingStates(): array
    {
        return $this->neededOutgoingStatesList;
    }

    /**
     * @param EventInterface $event
     * @return bool
     */
    protected function checkNeededOutgoingStates(EventInterface $event): \bool
    {
        $neededOutgoingStatesList = $this->listNeededOutgoingStates();
        if (empty($neededOutgoingStatesList)) {
            return true;
        }

        $outgoingStatesList = $event->getOutgoingStates();
        return empty(array_diff($neededOutgoingStatesList, $outgoingStatesList));
    }

    /**
     * @return string[]
     */
    public function listNeededStates(): array
    {
        return $this->neededStatesList;
    }

    /**
     * @param EventInterface $event
     * @return bool
     */
    protected function checkNeededStates(EventInterface $event): \bool
    {
        $neededStatesList = $this->listNeededStates();
        if (empty($neededStatesList)) {
            return true;
        }

        $enabledStatesList = $event->getObject()->listEnabledStates();
        return empty(array_diff($neededStatesList, $enabledStatesList));
    }

    /**
     * @return string[]
     */
    public function listForbiddenStates(): array
    {
        return $this->forbiddenStatesList;
    }

    /**
     * @param EventInterface $event
     * @return bool
     */
    protected function checkForbiddenStates(EventInterface $event): \bool
    {
        $forbiddenStatesList = $this->listForbiddenStates();
        if (empty($forbiddenStatesList)) {
            return true;
        }

        $enabledStatesList = $event->getObject()->listEnabledStates();
        return empty(array_intersect($forbiddenStatesList, $enabledStatesList));
    }

    /**
     * @return string
     */
    public function getNeededStatedClass(): \string
    {
        return $this->neededStatedClassName;
    }

    /**
     * @param EventInterface $event
     * @return bool
     */
    protected function checkNeededStatedClass(EventInterface $event): \bool
    {
        $neededStatedClassName = $this->getNeededStatedClass();
        if (empty($neededStatedClassName)) {
            return true;
        }

        return $neededStatedClassName = $event->getObserved()->getStatedClassName();
    }

    /**
     * {@inheritdoc}
     */
    public function getNeededStatedObject()
    {
        return $this->neededStatedObject;
    }

    /**
     * @param EventInterface $event
     * @return bool
     */
    protected function checkNeededStatedObject(EventInterface $event): \bool
    {
        $neededStatedObject = $this->getNeededStatedObject();
        if (!$neededStatedObject instanceof LifeCyclableInterface) {
            return true;
        }

        return $neededStatedObject === $event->getObject();
    }

    /**
     * {@inheritdoc}
     */
    public function isAllowedToRun(EventInterface $event): \bool
    {
        if (!$this->checkNeededIncomingStates($event)) {
            return false;
        }

        if (!$this->checkNeededOutgoingStates($event)) {
            return false;
        }

        if (!$this->checkNeededStates($event)) {
            return false;
        }

        if (!$this->checkForbiddenStates($event)) {
            return false;
        }

        if (!$this->checkNeededStatedClass($event)) {
            return false;
        }

        if (!$this->checkNeededStatedObject($event)) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(EventInterface $event)
    {
        if ($this->isAllowedToRun($event)) {
            $callback = $this->callback;
            $callback($event);
        }
    }
}