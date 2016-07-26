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

use Teknoo\States\LifeCycle\Scenario\ScenarioBuilder;
use Teknoo\States\LifeCycle\Tokenization\Tokenizer;
use Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;

/**
 * Class ScenarioBuilderTest.
 *
 * @covers Teknoo\States\LifeCycle\Scenario\ScenarioBuilder
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class ScenarioBuilderTest extends AbstractScenarioBuilderTest
{
    /**
     * @var Tokenizer
     */
    protected $tokenizer;

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Tokenizer
     */
    public function getTokenizerMock()
    {
        if (!$this->tokenizer instanceof Tokenizer) {
            $this->tokenizer = $this->createMock('Teknoo\States\LifeCycle\Tokenization\Tokenizer');
        }

        return $this->tokenizer;
    }

    /**
     * @return ScenarioBuilder
     */
    public function build()
    {
        return new ScenarioBuilder(
            $this->getTokenizerMock()
        );
    }

    public function testWhenValue()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->when('eventName'));
        $this->assertEquals(['eventName'], $service->getEventNamesList());
    }

    public function testTowardStatedClassValue()
    {
        $service = $this->build();
        $this->getTokenizerMock()->expects($this->once())->method('getStatedClassNameToken')->with('my\Stated\CustomClass')->willReturn('my_stated_customclass');
        $this->assertEquals($service, $service->towardStatedClass('my\Stated\CustomClass'));
        $this->assertEquals(['my_stated_customclass'], $service->getEventNamesList());
        $this->assertEquals('my\Stated\CustomClass', $service->getStatedClassName());
    }

    public function testTowardObservedValue()
    {
        /*
         * @var ObservedInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $observed = $this->createMock('Teknoo\States\LifeCycle\Observing\ObservedInterface');
        $acme = new Acme();
        $observed->expects($this->once())->method('getObject')->willReturn($acme);
        $service = $this->build();
        $this->getTokenizerMock()->expects($this->once())->method('getStatedClassInstanceToken')->with($acme)->willReturn('my_stated_customclass');
        $this->assertEquals($service, $service->towardObserved($observed));
        $this->assertEquals(['my_stated_customclass'], $service->getEventNamesList());
        $this->assertEquals($observed, $service->getObserved());
    }

    public function testIfInStateValueValue()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->ifInState('stateName'));
        $this->assertEquals(['stateName'], $service->getNeededStatesList());
    }

    public function testIfNotInStateValueValue()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->ifNotInState('stateName'));
        $this->assertEquals(['stateName'], $service->getForbiddenStatesList());
    }

    public function testOnIncomingStateValue()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->onIncomingState('stateName'));
        $this->assertEquals(['stateName'], $service->getNeededIncomingStatesList());
    }

    public function testOnOutgoingStateValue()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->onOutgoingState('stateName'));
        $this->assertEquals(['stateName'], $service->getNeededOutgoingStatesList());
    }

    public function testRunValue()
    {
        $service = $this->build();
        $callable = function () {};
        $this->assertEquals($service, $service->run($callable));
        $this->assertEquals($callable, $service->getCallable());
    }
}
