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
 * Interface ManagerInterface
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
interface ManagerInterface
{
    /**
     * @return EventDispatcherInterface
     */
    public function getDispatcher();

    /**
     * @param EventDispatcherInterface $dispatcher
     * @return ManagerInterface
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher): ManagerInterface;

    /**
     * @param ScenarioInterface $scenario
     * @return ManagerInterface
     */
    public function registerScenario(ScenarioInterface $scenario): ManagerInterface;

    /**
     * @param ScenarioInterface $scenario
     * @return ManagerInterface
     */
    public function unregisterScenario(ScenarioInterface $scenario): ManagerInterface;

    /**
     * @return ScenarioInterface[]
     */
    public function listScenarii(): array;
}