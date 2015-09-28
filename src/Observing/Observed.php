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
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\States\LifeCycle\Observing;

use UniAlteri\States\LifeCycle\Event\Event;
use UniAlteri\States\LifeCycle\Event\EventInterface;
use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;
use UniAlteri\States\LifeCycle\Trace\Entry;
use UniAlteri\States\LifeCycle\Trace\Trace;
use UniAlteri\States\LifeCycle\Trace\TraceInterface;

/**
 * Class Observed
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class Observed implements ObservedInterface
{
    /**
     * @var LifeCyclableInterface
     */
    private $object;

    /**
     * @var ObserverInterface
     */
    private $observer;

    /**
     * @var TraceInterface
     */
    private $trace;

    /**
     * @var EventInterface
     */
    private $lastEvent;

    /**
     * {@inheritdoc}
     */
    public function __construct(LifeCyclableInterface $object, ObserverInterface $observer)
    {
        $this->object = $object;
        $this->observer = $observer;
        $this->trace = new Trace($this);
    }

    /**
     * {@inheritdoc}
     */
    public function getObject(): LifeCyclableInterface
    {
        return $this->object;
    }

    /**
     * {@inheritdoc}
     */
    public function getObserver(): ObserverInterface
    {
        return $this->observer;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatedClassName(): \string
    {
        return get_class($this->object);
    }

    /**
     * @return string[]
     */
    protected function getLastEnabledStates()
    {
        $lastEnabledStates = [];
        $trace = $this->getStateTrace();

        if (false === $trace->isEmpty()) {
            $lastEntry = $trace->getLastEntry();
            if ($lastEntry instanceof Entry) {
                $lastEnabledStates = $lastEntry->getEnabledState();
            }
        }

        return $lastEnabledStates;
    }

    /**
     * @return $this
     */
    protected function buildEvent()
    {
        $currentEnabledStates = $this->getObject()->listEnabledStates();
        $lastEnabledStates = $this->getLastEnabledStates();

        $incomingStates = array_diff($currentEnabledStates, $lastEnabledStates);
        $outgoingStates = array_diff($lastEnabledStates, $currentEnabledStates);

        $this->lastEvent = new Event($this, $incomingStates, $outgoingStates);

        return $this;
    }

    /**
     * @return $this
     */
    protected function updateTrace()
    {
        $trace = $this->getStateTrace();
        $lastEntry = null;
        if (false === $trace->isEmpty()) {
            $lastEntry = $trace->getLastEntry();
        }

        $trace->addEntry(
                new Entry(
                    $this,
                    $this->getObject()->listEnabledStates(),
                    $lastEntry
                )
            );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function observeUpdate(): ObservedInterface
    {
        $this->buildEvent()
            ->updateTrace();

        $this->getObserver()->dispatchNotification($this);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStateTrace(): TraceInterface
    {
        return $this->trace;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastEvent(): EventInterface
    {
        if (!$this->lastEvent instanceof EventInterface) {
            throw new \RuntimeException('No event');
        }

        return $this->lastEvent;
    }
}