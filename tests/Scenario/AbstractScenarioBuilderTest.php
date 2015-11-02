<?php

/**
 * States.
 *
 * LICENSE
 *
 * This source file is subject to the MIT license and the version 3 of the GPL3
 * license that are bundled with this package in the folder licences
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@uni-alteri.com so we can send you a copy immediately.
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace Teknoo\Tests\States\LifeCycle\Scenario;

use Teknoo\States\LifeCycle\Scenario\ScenarioBuilderInterface;

/**
 * Class AbstractScenarioBuilderTest.
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
abstract class AbstractScenarioBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return ScenarioBuilderInterface
     */
    abstract public function build();

    /**
     * @expectedException \TypeError
     */
    public function testWhenBadArg()
    {
        $this->build()->when(new \stdClass());
    }

    public function testWhen()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->when('eventName'));
    }

    /**
     * @expectedException \TypeError
     */
    public function testTowardStatedClassBadArg()
    {
        $this->build()->towardStatedClass(new \stdClass());
    }

    public function testTowardStatedClass()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->towardStatedClass('my\Stated\CustomClass'));
    }

    /**
     * @expectedException \TypeError
     */
    public function testTowardObservedBadArg()
    {
        $this->build()->towardObserved(new \stdClass());
    }

    public function testTowardObserved()
    {
        /*
         * @var ObservedInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $observed = $this->getMock('Teknoo\States\LifeCycle\Observing\ObservedInterface');
        $service = $this->build();
        $this->assertEquals($service, $service->towardObserved($observed));
    }

    /**
     * @expectedException \TypeError
     */
    public function testIfInStateBadArg()
    {
        $this->build()->ifInState(new \stdClass());
    }

    public function testIfInState()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->ifInState('stateName'));
    }

    /**
     * @expectedException \TypeError
     */
    public function testIfNotInStateBadArg()
    {
        $this->build()->ifNotInState(new \stdClass());
    }

    public function testIfNotInState()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->ifNotInState('stateName'));
    }

    /**
     * @expectedException \TypeError
     */
    public function testOnIncomingStateBadArg()
    {
        $this->build()->onIncomingState(new \stdClass());
    }

    public function testOnIncomingState()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->onIncomingState('stateName'));
    }

    /**
     * @expectedException \TypeError
     */
    public function testOnOutgoingStateBadArg()
    {
        $this->build()->onOutgoingState(new \stdClass());
    }

    public function testOnOutgoingState()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->onOutgoingState('stateName'));
    }

    /**
     * @expectedException \TypeError
     */
    public function testRunBadArg()
    {
        $this->build()->run(new \stdClass());
    }

    public function testRun()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->run(function () {}));
    }

    public function testBuild()
    {
        $builder = $this->build();
        $scenario = $this->getMock('Teknoo\States\LifeCycle\Scenario\ScenarioInterface');
        $scenario->expects($this->once())->method('configure')->with($builder)->willReturnSelf();

        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Scenario\ScenarioInterface',
            $builder->build(
                $scenario
            )
        );
    }
}
