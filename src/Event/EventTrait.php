<?php

declare(strict_types=1);

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
 * Class Event
 * Default implementation of events used in lifecycle of stated class instances.
 *
 * @see EventInterface
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
trait EventTrait
{
    /**
     * @var ObservedInterface
     */
    private $observed;

    /**
     * List of incoming states of the observed instance when this event has been built.
     *
     * @var string[]
     */
    private $incomingStates;

    /**
     * List of outgoing states of the observed instance when this event has been built.
     *
     * @var string[]
     */
    private $outgoingStates;

    /**
     * {@inheritdoc}
     */
    public function __construct(ObservedInterface $observer, array $incomingStates, array $outgoingStates)
    {
        $this->observed = $observer;
        $this->incomingStates = $incomingStates;
        $this->outgoingStates = $outgoingStates;
    }

    /**
     * {@inheritdoc}
     */
    public function getObserved(): ObservedInterface
    {
        return $this->observed;
    }

    /**
     * @return LifeCyclableInterface
     */
    public function getObject(): LifeCyclableInterface
    {
        return $this->getObserved()->getObject();
    }

    /**
     * {@inheritdoc}
     */
    public function getEnabledStates(): array
    {
        return $this->getObject()->listEnabledStates();
    }

    /**
     * {@inheritdoc}
     */
    public function getIncomingStates(): array
    {
        return $this->incomingStates;
    }

    /**
     * {@inheritdoc}
     */
    public function getOutgoingStates(): array
    {
        return $this->outgoingStates;
    }
}
