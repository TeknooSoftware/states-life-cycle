<?php

namespace UniAlteri\Tests\States\LifeCycle\Observing;

use UniAlteri\States\LifeCycle\Observing\Observed;

/**
 * Class ObservedTest
 *
 * @covers UniAlteri\States\LifeCycle\Observing\Observed
 */
class ObservedTest extends AbstractObservedTest
{
    /**
     * @param mixed $instance
     * @param mixed $observer
     * @return Observed
     */
    public function build($instance, $observer)
    {
        return new Observed($instance, $observer);
    }
}