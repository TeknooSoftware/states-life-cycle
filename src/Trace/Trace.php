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
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class Trace implements TraceInterface
{
    /**
     * @var \SplStack
     */
    private $stack;

    /**
     * Default constructor
     */
    public function __construct()
    {
        $this->stack = new \SplStack();
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
     * @param ObservedInterface $observed
     * @param array $enabledStatesList
     * @return TraceInterface
     */
    public function addEntry(ObservedInterface $observed, array $enabledStatesList): TraceInterface
    {
        $lastEntry = null;
        if (false === $this->isEmpty()) {
            $lastEntry = $this->getLastEntry();
        }

        $entry = new Entry($observed, $enabledStatesList, $lastEntry);

        if ($lastEntry instanceof EntryInterface) {
            $lastEntry->setNext($entry);
        }

        $this->stack->push($entry);

        return $this;
    }
}