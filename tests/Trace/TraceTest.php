<?php

namespace UniAlteri\Tests\States\LifeCycle\Trace;

use UniAlteri\States\LifeCycle\Trace\Trace;

/**
 * Class TraceTest.
 *
 * @covers UniAlteri\States\LifeCycle\Trace\Trace
 */
class TraceTest extends AbstractTraceTest
{
    /**
     * @param $observedInterface
     *
     * @return Trace
     */
    public function build($observedInterface)
    {
        return new Trace($observedInterface);
    }
}
