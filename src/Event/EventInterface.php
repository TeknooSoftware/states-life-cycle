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

use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface;

/**
 * Interface EventInterface
 * Interface used to create event to broadcast changes about a stated class instances to the system.
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
interface EventInterface
{
    /**
     * @param ObservedInterface $observer
     * @param array             $incomingStates
     * @param array             $outgoingStates
     *
     * @return mixed
     */
    public function __construct(ObservedInterface $observer, array $incomingStates, array $outgoingStates);

    /**
     * To get the object managing the observation about the observed stated class instaces.
     *
     * @return ObservedInterface
     */
    public function getObserved(): ObservedInterface;

    /**
     * Shortcut to get the observed stated class instance.
     *
     * @return LifeCyclableInterface
     */
    public function getObject(): LifeCyclableInterface;

    /**
     * To get the list of enabled states of the observed instance when this event has been built.
     *
     * @return string[]
     */
    public function getEnabledStates(): array;

    /**
     *To get incoming states of the observed instance when this event has been built.
     *
     * @return string[]
     */
    public function getIncomingStates(): array;

    /**
     * To get outgoing states of the observed instance when this event has been built.
     *
     * @return string[]
     */
    public function getOutgoingStates(): array;
}
