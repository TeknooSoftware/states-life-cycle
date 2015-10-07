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
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Event\EventInterface;
use UniAlteri\States\LifeCycle\Observing\ObservedInterface;

/***
 * Interface ScenarioInterface
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
interface ScenarioInterface
{
    /**
     * @param ScenarioBuilder $scenarioBuilder
     * @return ScenarioInterface
     */
    public function configure(ScenarioBuilder $scenarioBuilder): ScenarioInterface ;

    /**
     * @return string[]
     */
    public function getEventsNamesList(): array;

    /**
     * @return string[]
     */
    public function listNeededIncomingStates(): array;

    /**
     * @return string[]
     */
    public function listNeededOutgoingStates(): array;

    /**
     * @return string[]
     */
    public function listNeededStates(): array;

    /**
     * @return string[]
     */
    public function listForbiddenStates(): array;

    /**
     * @return string
     */
    public function getNeededStatedClass(): \string;

    /**
     * @return ObservedInterface|null
     */
    public function getNeededStatedObject();

    /**
     * @param EventInterface $event
     * @return bool
     */
    public function isAllowedToRun(EventInterface $event): \bool;

    /**
     * @param EventInterface $event
     * @return mixed
     */
    public function __invoke(EventInterface $event);
}