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
namespace Teknoo\States\LifeCycle\Observing;

use Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface;

/**
 * Class ObservedFactory
 * Default implementation of the factory to build new observed instance used
 * to manage observation between observed states class and its observer.
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class ObservedFactory implements ObservedFactoryInterface
{
    /**
     * @var string
     */
    private $observedClassName = '';

    /**
     * @var string
     */
    private $eventClassName = '';

    /**
     * @var string
     */
    private $traceClassName = '';

    /**
     * @param string $observedClassName
     * @param string $eventClassName
     * @param string $traceClassName
     */
    public function __construct(string $observedClassName, string $eventClassName, string $traceClassName)
    {
        $this->checkObservedClassName($observedClassName);
        $this->checkTraceClassName($traceClassName);
        $this->eventClassName = $eventClassName;
    }

    /**
     * @param string $observedClassName
     *
     * @return $this
     */
    private function checkObservedClassName(string $observedClassName)
    {
        if (!\class_exists($observedClassName)) {
            throw new \RuntimeException('Missing observed class '.$observedClassName);
        }

        $interfaceImplementingList = \class_implements($observedClassName);

        if (!isset($interfaceImplementingList['Teknoo\States\LifeCycle\Observing\ObservedInterface'])) {
            throw new \RuntimeException('The observed class does not implement the ObservedFactoryInterface');
        }

        $this->observedClassName = $observedClassName;

        return $this;
    }

    /**
     * @param string $traceClassName
     *
     * @return $this
     */
    private function checkTraceClassName(string $traceClassName)
    {
        if (!\class_exists($traceClassName)) {
            throw new \RuntimeException('Missing trace class '.$traceClassName);
        }

        $interfaceImplementingList = \class_implements($traceClassName);

        if (!isset($interfaceImplementingList['Teknoo\States\LifeCycle\Trace\TraceInterface'])) {
            throw new \RuntimeException('The trace class does not implement the ObservedFactoryInterface');
        }

        $this->traceClassName = $traceClassName;

        return $this;
    }

    /**
     * @param ObserverInterface     $observer
     * @param LifeCyclableInterface $lifeCyclableInstance
     *
     * @return ObservedInterface
     */
    public function create(ObserverInterface $observer, LifeCyclableInterface $lifeCyclableInstance): ObservedInterface
    {
        $traceClassName = $this->traceClassName;
        $observedClassName = $this->observedClassName;

        return new $observedClassName(
            $lifeCyclableInstance,
            $observer,
            new $traceClassName(),
            $this->eventClassName
        );
    }
}
