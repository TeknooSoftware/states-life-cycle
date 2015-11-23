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
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
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
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
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
     * @param ObserverInterface $observer
     * @param TraceInterface $trace
     * @param string $eventClassName
     */
    public function __construct(
        LifeCyclableInterface $object,
        ObserverInterface $observer,
        TraceInterface $trace,
        \string $eventClassName
    );

    /**
     * @return LifeCyclableInterface
     */
    public function getObject(): LifeCyclableInterface;

    /**
     * @return ObserverInterface
     */
    public function getObserver(): ObserverInterface;

    /**
     * @return string
     */
    public function getStatedClassName(): \string;

    /**
     * @return ObservedInterface
     */
    public function observeUpdate(): ObservedInterface;

    /**
     * @return TraceInterface
     */
    public function getStateTrace(): TraceInterface;

    /**
     * @return EventInterface
     */
    public function getLastEvent(): EventInterface;
}
