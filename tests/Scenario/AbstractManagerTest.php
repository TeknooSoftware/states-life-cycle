<?php

namespace UniAlteri\Tests\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Scenario\ManagerInterface;
use UniAlteri\States\LifeCycle\Scenario\ScenarioInterface;

/**
 * Class AbstractManagerTest
 * @package UniAlteri\Tests\States\LifeCycle\Scenario
 */
abstract class AbstractManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return ManagerInterface
     */
    abstract public function build();

    /**
     * @expectedException \TypeError
     */
    public function testRegisterScenarioBadArg()
    {
        $this->build()->registerScenario(new \stdClass());
    }

    public function testRegisterScenario()
    {
        /**
         * @var ScenarioInterface|\PHPUnit_Framework_MockObject_MockObject $scenario
         */
        $scenario = $this->getMock('UniAlteri\States\LifeCycle\Scenario\ScenarioInterface');
        $service = $this->build();
        $this->assertEquals($service, $service->registerScenario($scenario));
    }

    /**
     * @expectedException \TypeError
     */
    public function testUnregisterScenarioBadArg()
    {
        $this->build()->unregisterScenario(new \stdClass());
    }

    public function testUnregisterScenario()
    {
        /**
         * @var ScenarioInterface|\PHPUnit_Framework_MockObject_MockObject $scenario
         */
        $scenario = $this->getMock('UniAlteri\States\LifeCycle\Scenario\ScenarioInterface');
        $service = $this->build();
        $this->assertEquals($service, $service->unregisterScenario($scenario));
    }

    public function testListScenarii()
    {
        $this->assertTrue(is_array($this->build()->listScenarii()));
    }
}