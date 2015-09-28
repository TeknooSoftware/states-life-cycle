<?php

namespace UniAlteri\Tests\States\LifeCycle\Event;

use UniAlteri\States\LifeCycle\Event\Event;

/**
 * Class EventTest.
 *
 * @covers UniAlteri\States\LifeCycle\Event\Event
 */
class EventTest extends AbstractEventTest
{
    /**
     * @param $observed
     * @param $incomingState
     * @param $outGoingState
     *
     * @return Event
     */
    public function build($observed, $incomingState, $outGoingState)
    {
        return new Event($observed, $incomingState, $outGoingState);
    }
}
