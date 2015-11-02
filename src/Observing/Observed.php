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

namespace Teknoo\States\LifeCycle\Observing;

use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface;
use Teknoo\States\LifeCycle\Trace\Entry;
use Teknoo\States\LifeCycle\Trace\TraceInterface;

/**
 * Class Observed
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
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
     * @var string
     */
    private $eventClassName;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        LifeCyclableInterface $object,
        ObserverInterface $observer,
        TraceInterface $trace,
        \string $eventClassName
    ) {
        $this->object = $object;
        $this->observer = $observer;
        $this->trace = $trace;
        $this->checkEventClassName($eventClassName);
    }

    protected function checkEventClassName(\string $eventClassName)
    {
        if (!class_exists($eventClassName)) {
            throw new \RuntimeException('Missing event class '.$eventClassName);
        }

        $interfaceImplementingList = class_implements($eventClassName);

        if (!isset($interfaceImplementingList['Teknoo\States\LifeCycle\Event\EventInterface'])) {
            throw new \RuntimeException('The event class does not implement the EventInterface');
        }

        $this->eventClassName = $eventClassName;

        return $this;
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
        $classNameParts = explode('\\', get_class($this->object));
        if (count($classNameParts) > 1) {
            array_pop($classNameParts);
        }

        return implode('\\', $classNameParts);
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

        $eventClassName = $this->eventClassName;
        $this->lastEvent = new $eventClassName($this, $incomingStates, $outgoingStates);

        return $this;
    }

    /**
     * @return $this
     */
    protected function updateTrace()
    {
        $trace = $this->getStateTrace();

        $trace->addEntry(
            $this,
            $this->getObject()->listEnabledStates()
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