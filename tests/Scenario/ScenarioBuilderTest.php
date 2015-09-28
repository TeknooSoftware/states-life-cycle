<?php

namespace UniAlteri\Tests\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Scenario\ScenarioBuilder;

/**
 * Class ScenarioBuilderTest.
 *
 * @covers UniAlteri\States\LifeCycle\Scenario\ScenarioBuilder
 */
class ScenarioBuilderTest extends AbstractScenarioBuilderTest
{
    /**
     * @return ScenarioBuilder
     */
    public function build()
    {
        return new ScenarioBuilder();
    }
}
