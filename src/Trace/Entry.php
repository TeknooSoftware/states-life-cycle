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
 * Class Entry
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class Entry implements EntryInterface
{
    /**
     * @var ObservedInterface
     */
    private $observed;

    /**
     * @var array
     */
    private $enabledStatesList;

    /**
     * @var EntryInterface
     */
    private $previous;

    /**
     * @var EntryInterface
     */
    private $next;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        ObservedInterface $observed,
        array $enabledStatesList,
        EntryInterface $previous=null
    )
    {
        $this->observed = $observed;
        $this->enabledStatesList = $enabledStatesList;
        $this->previous = $previous;
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
    public function getEnabledState(): array
    {
        return $this->enabledStatesList;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    /**
     * {@inheritdoc}
     */
    public function setNext(EntryInterface $next): EntryInterface
    {
        $this->next = $next;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNext()
    {
        return $this->next;
    }
}