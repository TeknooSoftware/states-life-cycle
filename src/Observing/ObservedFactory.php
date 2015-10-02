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

use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableInterface;

/**
 * Class ObservedFactory
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class ObservedFactory implements ObservedFactoryInterface
{
    /**
     * @var string
     */
    protected $observedClassName = '';

    /**
     * @var string
     */
    protected $eventClassName = '';

    /**
     * @var string
     */
    protected $traceClassName = '';

    /**
     * @param string $observedClassName
     * @param string $eventClassName
     * @param string $traceClassName
     */
    public function __construct(\string $observedClassName, \string $eventClassName, \string $traceClassName)
    {
        $this->checkObservedClassName($observedClassName);
        $this->checkTraceClassName($traceClassName);
        $this->eventClassName = $eventClassName;
    }

    /**
     * @param string $observedClassName
     * @return $this
     */
    protected function checkObservedClassName(\string $observedClassName)
    {
        if (!class_exists($observedClassName)) {
            throw new \RuntimeException('Missing observed class '.$observedClassName);
        }

        $interfaceImplementingList = class_implements($observedClassName);

        if (!isset($interfaceImplementingList['UniAlteri\States\LifeCycle\Observing\ObservedInterface'])) {
            throw new \RuntimeException('The observed class does not implement the ObservedFactoryInterface');
        }

        $this->observedClassName = $observedClassName;

        return $this;
    }

    /**
     * @param string $traceClassName
     * @return $this
     */
    protected function checkTraceClassName(\string $traceClassName)
    {
        if (!class_exists($traceClassName)) {
            throw new \RuntimeException('Missing trace class '.$traceClassName);
        }

        $interfaceImplementingList = class_implements($traceClassName);

        if (!isset($interfaceImplementingList['UniAlteri\States\LifeCycle\Trace\TraceInterface'])) {
            throw new \RuntimeException('The trace class does not implement the ObservedFactoryInterface');
        }

        $this->traceClassName = $traceClassName;

        return $this;
    }

    /**
     * @param ObserverInterface $observer
     * @param LifeCyclableInterface $lifeCyclableInstance
     * @return ObservedInterface
     */
    public function create(ObserverInterface $observer, LifeCyclableInterface $lifeCyclableInstance): ObservedInterface
    {
        $traceClassName = $this->traceClassName;
        $observedClassName = $this->observedClassName;
        return new $observedClassName(
            $lifeCyclableInstance,
            $observer,
            new $traceClassName,
            $this->eventClassName
        );
    }
}