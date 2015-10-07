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

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;

/***
 * Interface ScenarioBuilderInterface
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
interface ScenarioBuilderInterface
{
    /**
     * @param string $eventName
     * @return ScenarioBuilderInterface
     */
    public function when(\string $eventName): ScenarioBuilderInterface;

    /**
     * @param string $statedClassName
     * @return ScenarioBuilderInterface
     */
    public function towardStatedClass(\string $statedClassName): ScenarioBuilderInterface;

    /**
     * @param ObservedInterface $observed
     * @return ScenarioBuilderInterface
     */
    public function towardObserved(ObservedInterface $observed): ScenarioBuilderInterface;

    /**
     * @param string $stateName
     * @return ScenarioBuilderInterface
     */
    public function ifNotInState(\string $stateName): ScenarioBuilderInterface;

    /**
     * @param string $stateName
     * @return ScenarioBuilderInterface
     */
    public function ifInState(\string $stateName): ScenarioBuilderInterface;

    /**
     * @param string $stateName
     * @return ScenarioBuilderInterface
     */
    public function onIncomingState(\string $stateName): ScenarioBuilderInterface;

    /**
     * @param string $stateName
     * @return ScenarioBuilderInterface
     */
    public function onOutgoingState(\string $stateName): ScenarioBuilderInterface;

    /**
     * @param callable $callable
     * @return ScenarioBuilderInterface
     */
    public function run(callable $callable): ScenarioBuilderInterface;

    /**
     * @param ScenarioInterface $scenario
     * @return ScenarioInterface
     */
    public function build(ScenarioInterface $scenario): ScenarioInterface;
}