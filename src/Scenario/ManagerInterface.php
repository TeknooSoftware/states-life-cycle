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

namespace Teknoo\States\LifeCycle\Scenario;

use Teknoo\States\LifeCycle\Event\EventDispatcherBridgeInterface;

/**
 * Interface ManagerInterface
 * Interface to manage to store all enabled scenarii and register them into the event dispatcher.
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
interface ManagerInterface
{
    /**
     * To get the dispatcher used to register scenarii.
     *
     * @return EventDispatcherBridgeInterface
     */
    public function getDispatcher();

    /**
     * To register the dispatcher to use to register scenarii.
     *
     * @param EventDispatcherBridgeInterface $dispatcher
     *
     * @return ManagerInterface
     */
    public function setDispatcher(EventDispatcherBridgeInterface $dispatcher): ManagerInterface;

    /**
     * To register a scenario into the dispatched.
     *
     * @param ScenarioInterface $scenario
     *
     * @return ManagerInterface
     */
    public function registerScenario(ScenarioInterface $scenario): ManagerInterface;

    /**
     * To unregister a scenario from the dispatcher.
     *
     * @param ScenarioInterface $scenario
     *
     * @return ManagerInterface
     */
    public function unregisterScenario(ScenarioInterface $scenario): ManagerInterface;

    /**
     * To return all enabled scenarii registered in the dispatcher.
     *
     * @return ScenarioInterface[]
     */
    public function listScenarii(): array;
}
