<?php

namespace UniAlteri\Tests\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Scenario\Scenario;

/**
 * Class ScenarioTest
 *
 * @covers UniAlteri\States\LifeCycle\Scenario\Scenario
 */
class ScenarioTest extends AbstractScenarioTest
{
    /**
     * @return Scenario
     */
    public function build()
    {
        return new Scenario();
    }
}