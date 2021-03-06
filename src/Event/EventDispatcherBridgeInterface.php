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
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */

namespace Teknoo\States\LifeCycle\Event;

interface EventDispatcherBridgeInterface
{
    /**
     * Dispatches an event to all registered listeners.
     *
     * @param string         $eventName The name of the event to dispatch. The name of
     *                                  the event is the name of the method that is
     *                                  invoked on listeners
     * @param EventInterface $event     The event to pass to the event handlers/listeners
     *                                  If not supplied, an empty Event instance is created
     *
     * @return EventDispatcherBridgeInterface
     */
    public function dispatch($eventName, EventInterface $event = null): EventDispatcherBridgeInterface;

    /**
     * Adds an event listener that listens on the specified events.
     *
     * @param string   $eventName The event to listen on
     * @param callable $listener  The listener
     * @param int      $priority  The higher this value, the earlier an event
     *                            listener will be triggered in the chain (defaults to 0)
     *
     * @return EventDispatcherBridgeInterface
     */
    public function addListener($eventName, $listener, $priority = 0): EventDispatcherBridgeInterface;

    /**
     * Removes an event listener from the specified events.
     *
     * @param string   $eventName The event to remove a listener from
     * @param callable $listener  The listener to remove
     *
     * @return EventDispatcherBridgeInterface
     */
    public function removeListener($eventName, $listener): EventDispatcherBridgeInterface;
}
