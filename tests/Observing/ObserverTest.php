<?php

namespace UniAlteri\Tests\States\LifeCycle\Observing;

use UniAlteri\States\LifeCycle\Observing\Observer;

/**
 * Class ObserverTest.
 *
 * @covers UniAlteri\States\LifeCycle\Observing\Observer
 */
class ObserverTest extends AbstractObserverTest
{
    /**
     * @return Observer
     */
    public function build()
    {
        return new Observer();
    }
}
