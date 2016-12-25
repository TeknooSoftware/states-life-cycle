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

namespace Teknoo\States\LifeCycle\Observing;

use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface;
use Teknoo\States\LifeCycle\Trace\TraceInterface;

/**
 * Interface ObservedInterface
 * Interface to build observed instance : object to manage the observation between a stated class install
 * and its observer.
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
interface ObservedInterface
{
    /**
     * @param LifeCyclableInterface $object
     * @param ObserverInterface     $observer
     * @param TraceInterface        $trace
     * @param string                $eventClassName
     */
    public function __construct(
        LifeCyclableInterface $object,
        ObserverInterface $observer,
        TraceInterface $trace,
        string $eventClassName
    );

    /**
     * To retrieve the observed stated class instance.
     *
     * @return LifeCyclableInterface
     */
    public function getObject(): LifeCyclableInterface;

    /**
     * To retrieve the observer used in this relation.
     *
     * @return ObserverInterface
     */
    public function getObserver(): ObserverInterface;

    /**
     * To get the full qualified stated class name.
     *
     * @return string
     */
    public function getStatedClassName(): string;

    /**
     * Called by the observed stated class instance to notify to the observer that its states are changed.
     *
     * @return ObservedInterface
     */
    public function observeUpdate(): ObservedInterface;

    /**
     * To get the states trace of the observed object, to allow browse in and know previous states
     * and get its states evolution.
     *
     * @return TraceInterface
     */
    public function getStateTrace(): TraceInterface;

    /**
     * To get the last change of stated class instance.
     *
     * @return EventInterface
     */
    public function getLastEvent(): EventInterface;
}
