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
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\Tests\States\LifeCycle\Observing;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use UniAlteri\States\LifeCycle\Event\EventInterface;
use UniAlteri\States\LifeCycle\Observing\ObservedInterface;
use UniAlteri\States\LifeCycle\Observing\Observer;
use UniAlteri\States\LifeCycle\Tokenization\TokenizerInterface;

/**
 * Class ObserverTest.
 *
 * @covers UniAlteri\States\LifeCycle\Observing\Observer
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class ObserverTest extends AbstractObserverTest
{
    /**
     * @return Observer
     */
    public function build()
    {
        return new Observer();
    }

    public function testDispatchNotification()
    {
        /***
         * @var EventInterface|\PHPUnit_Framework_MockObject_MockObject $instance
         */
        $event = $this->getMock('UniAlteri\States\LifeCycle\Event\Event', [], [], '', false);
        /**
         * @var ObservedInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface');
        $instance->expects($this->any())->method('getLastEvent')->willReturn($event);
        $service = $this->build();
        /**
         * @var TokenizerInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $tokenizer = $this->getMock('UniAlteri\States\LifeCycle\Tokenization\TokenizerInterface');
        $tokenizer->expects($this->once())
            ->method('getToken')
            ->with($event)
            ->willReturn(['event_name1', 'event_name1:state1', 'event_name1:state2', 'event_name1:+state1', 'event_name1:-state3']);

        /**
         * @var EventDispatcherInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->assertEquals($service, $service->addEventDispatcher($dispatcher));
        $dispatcher->expects($this->exactly(5))
            ->method('dispatch')
            ->withConsecutive(
                ['event_name1', $event],
                ['event_name1:state1', $event],
                ['event_name1:state2', $event],
                ['event_name1:+state1', $event],
                ['event_name1:-state3', $event]);

        $service->setTokenizer($tokenizer);
        $this->assertEquals($service, $service->dispatchNotification($instance));
    }
}
