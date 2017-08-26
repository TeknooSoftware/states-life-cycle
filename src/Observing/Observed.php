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
use Teknoo\States\LifeCycle\Trace\EntryInterface;
use Teknoo\States\LifeCycle\Trace\TraceInterface;

/**
 * Class Observed
 * Default implementation to manage the observation between a stated class install
 * and its observer *.
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class Observed implements ObservedInterface
{
    /**
     * Observed stated class instance of this observation.
     *
     * @var LifeCyclableInterface
     */
    private $object;

    /**
     * Observer in this observation.
     *
     * @var ObserverInterface
     */
    private $observer;

    /**
     * Trace of the stated class instance to store its state evolution.
     *
     * @var TraceInterface
     */
    private $trace;

    /**
     * The last event corresponding to the currently states of the instance.
     *
     * @var EventInterface
     */
    private $lastEvent;

    /**
     * Class name to use to build new event.
     *
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
        string $eventClassName
    ) {
        $this->object = $object;
        $this->observer = $observer;
        $this->trace = $trace;
        $this->checkEventClassName($eventClassName);
    }

    /**
     * To check if the required event class name.
     *
     * @param string $eventClassName
     *
     * @return self
     */
    private function checkEventClassName(string $eventClassName): Observed
    {
        if (!\class_exists($eventClassName)) {
            throw new \RuntimeException('Missing event class '.$eventClassName);
        }

        $interfacesList = \class_implements($eventClassName);

        if (!isset($interfacesList['Teknoo\States\LifeCycle\Event\EventInterface'])) {
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
    public function getStatedClassName(): string
    {
        $classNameParts = \explode('\\', \get_class($this->object));
        if (\count($classNameParts) > 1) {
            \array_pop($classNameParts);
        }

        return \implode('\\', $classNameParts);
    }

    /**
     * @return string[]
     */
    private function getLastEnabledStates()
    {
        $lastEnabledStates = [];
        $trace = $this->getStateTrace();

        if (false === $trace->isEmpty()) {
            $lastEntry = $trace->getLastEntry();
            if ($lastEntry instanceof EntryInterface) {
                $lastEnabledStates = $lastEntry->getEnabledState();
            }
        }

        return $lastEnabledStates;
    }

    /**
     * Build event, retrieve current enabled states of the instace and compute difference with last enabled states.
     *
     * @return $this
     */
    private function buildEvent()
    {
        $currentEnabledStates = $this->getObject()->listEnabledStates();
        $lastEnabledStates = $this->getLastEnabledStates();

        //New state = current states - old states
        $incomingStates = \array_diff($currentEnabledStates, $lastEnabledStates);
        //Outgoing state = lst states - current states
        $outgoingStates = \array_diff($lastEnabledStates, $currentEnabledStates);

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

        $trace->addEntry($this, $this->getObject()->listEnabledStates());

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
