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
 * to richarddeloge@gmail.com so we can send you a copy immediately.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */

namespace Teknoo\Tests\States\LifeCycle\Scenario;

use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\LifeCycle\Scenario\ScenarioBuilderInterface;
use Teknoo\States\LifeCycle\Scenario\ScenarioInterface;

/**
 * Class AbstractScenarioBuilderTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
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
        self::assertEquals($service, $service->when('eventName'));
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
        self::assertEquals($service, $service->towardStatedClass('my\Stated\CustomClass'));
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
        $observed = $this->createMock(ObservedInterface::class);
        $service = $this->build();
        self::assertEquals($service, $service->towardObserved($observed));
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
        self::assertEquals($service, $service->ifInState('stateName'));
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
        self::assertEquals($service, $service->ifNotInState('stateName'));
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
        self::assertEquals($service, $service->onIncomingState('stateName'));
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
        self::assertEquals($service, $service->onOutgoingState('stateName'));
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
        self::assertEquals($service, $service->run(function () {
        }));
    }

    public function testBuild()
    {
        $builder = $this->build();
        $scenario = $this->createMock(ScenarioInterface::class);
        $scenario->expects(self::once())->method('configure')->with($builder)->willReturnSelf();

        self::assertInstanceOf(
            ScenarioInterface::class,
            $builder->build(
                $scenario
            )
        );
    }
}
