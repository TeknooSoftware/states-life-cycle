<?php

namespace UniAlteri\Tests\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Scenario\Manager;

/**
 * Class ManagerTest.
 *
 * @covers UniAlteri\States\LifeCycle\Scenario\Manager
 */
class ManagerTest extends AbstractManagerTest
{
    /**
     * @return Manager
     */
    public function build()
    {
        $dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');

        return new Manager($dispatcher);
    }
}
