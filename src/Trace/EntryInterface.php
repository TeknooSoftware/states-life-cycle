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
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
namespace Teknoo\States\LifeCycle\Trace;

use Teknoo\States\LifeCycle\Observing\ObservedInterface;

/**
 * Interface EntryInterface
 * Interface to represent entry in the state trace of stated class to know the story of the obect.
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
interface EntryInterface
{
    /**
     * @param ObservedInterface   $observed
     * @param string[]            $enabledStatesList
     * @param EntryInterface|null $previous
     */
    public function __construct(
        ObservedInterface $observed,
        array $enabledStatesList,
        EntryInterface $previous = null
    );

    /**
     * Get the observed relation, at the origin of this event.
     *
     * @return ObservedInterface
     */
    public function getObserved(): ObservedInterface;

    /**
     * Get all enabled states of the stated class instance when this entry has been generated.
     *
     * @return string[]
     */
    public function getEnabledState(): array;

    /**
     * Get the previous entry from the trace.
     *
     * @return EntryInterface|null
     */
    public function getPrevious();

    /**
     * To update the next entry from the trace.
     *
     * @param EntryInterface $next
     *
     * @return EntryInterface
     */
    public function setNext(EntryInterface $next): EntryInterface;

    /**
     * Get the next entry from the trace.
     *
     * @return EntryInterface|null
     */
    public function getNext();
}
