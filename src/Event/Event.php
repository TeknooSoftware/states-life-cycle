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

namespace Teknoo\States\LifeCycle\Event;

use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

/**
 * Class Event
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class Event extends SymfonyEvent implements EventInterface
{
    /**
     * @var ObservedInterface
     */
    private $observed;

    /**
     * @var string[]
     */
    private $incomingStates;

    /**
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
     * {@inheritdoc}
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