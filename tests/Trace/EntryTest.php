<?php

namespace UniAlteri\Tests\States\LifeCycle\Trace;

use UniAlteri\States\LifeCycle\Trace\Entry;
use UniAlteri\States\LifeCycle\Trace\EntryInterface;

/**
 * Class EntityTest
 *
 * @covers UniAlteri\States\LifeCycle\Trace\Entry
 */
class EntityTest extends AbstractEntityTest
{
    /**
     * @param $observedInterface
     * @param $enabledStatesList
     * @return EntryInterface
     */
    public function build($observedInterface, $enabledStatesList)
    {
        return new Entry($observedInterface, $enabledStatesList);
    }
}