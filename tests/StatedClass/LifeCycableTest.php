<?php

namespace UniAlteri\Tests\States\LifeCycle\StatedClass;

use UniAlteri\States\LifeCycle\StatedClass\LifeCyclableTrait;
use UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;

/**
 * Class LifeCycableTest.
 *
 * @covers UniAlteri\States\LifeCycle\StatedClass\LifeCyclableTrait
 */
class LifeCycableTest extends AbstractLifeCyclableTest
{
    /**
     * @return LifeCyclableTrait
     */
    public function build()
    {
        return new Acme();
    }
}
