<?php

namespace UniAlteri\Tests\States\LifeCycle\Trace;

use UniAlteri\States\LifeCycle\Trace\Entry;
use UniAlteri\States\LifeCycle\Trace\EntryInterface;

/**
 * Class EntityTest.
 *
 * @covers UniAlteri\States\LifeCycle\Trace\Entry
 */
class EntryTest extends AbstractEntryTest
{
    /**
     * @param $observedInterface
     * @param $enabledStatesList
     * @param $previous
     *
     * @return EntryInterface
     */
    public function build($observedInterface, $enabledStatesList, $previous = null)
    {
        return new Entry($observedInterface, $enabledStatesList, $previous);
    }
}
