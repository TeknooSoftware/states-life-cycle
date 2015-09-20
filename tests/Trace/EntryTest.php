<?php

namespace UniAlteri\Tests\States\LifeCycle\Trace;

use UniAlteri\States\LifeCycle\Trace\Entry;

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
     * @param $previous
     * @return Entry
     */
    public function build($observedInterface, $enabledStatesList, $previous)
    {
        return new Entry($observedInterface, $enabledStatesList, $previous)
    }
}