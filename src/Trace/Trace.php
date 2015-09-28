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

namespace UniAlteri\States\LifeCycle\Trace;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;

/**
 * Class Trace
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class Trace implements TraceInterface
{
    /**
     * @var ObservedInterface;
     */
    private $observed;

    /**
     * @var \SplStack
     */
    private $stack;

    /**
     * {@inheritdoc}
     */
    public function __construct(ObservedInterface $observedInterface)
    {
        $this->observed = $observedInterface;
        $this->stack = new \SplStack();
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
    public function getTrace(): \SplStack
    {
        return $this->stack;
    }

    /**
     * @return bool
     */
    public function isEmpty(): \bool
    {
        return 0 === $this->stack->count();
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstEntry(): EntryInterface
    {
        if (0 === $this->stack->count()) {
            throw new \RuntimeException('Trace empty');
        }

        return $this->stack->bottom();
    }

    /**
     * {@inheritdoc}
     */
    public function getLastEntry(): EntryInterface
    {
        if (0 === $this->stack->count()) {
            throw new \RuntimeException('Trace empty');
        }

        return $this->stack->top();
    }

    /**
     * {@inheritdoc}
     */
    public function addEntry(EntryInterface $entry): TraceInterface
    {
        if (false === $this->isEmpty()) {
            $lastEntry = $this->getLastEntry();
            $lastEntry->setNext($entry);
        }

        $this->stack->push($entry);

        return $this;
    }
}