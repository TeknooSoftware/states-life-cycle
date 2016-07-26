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
namespace Teknoo\Tests\States\LifeCycle\Observing;

use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\Observing\ObservedFactoryInterface;
use Teknoo\States\LifeCycle\Observing\Observer;

/**
 * Class ObserverTest.
 *
 * @covers Teknoo\States\LifeCycle\Observing\Observer
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class ObserverTest extends AbstractObserverTest
{
    /**
     * @var ObservedFactoryInterface
     */
    private $observedFactory;

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ObservedFactoryInterface
     */
    protected function getObservedFactoryInterfaceMock()
    {
        if (!$this->observedFactory instanceof ObservedFactoryInterface) {
            $this->observedFactory = $this->createMock('Teknoo\States\LifeCycle\Observing\ObservedFactoryInterface');
        }

        return $this->observedFactory;
    }

    /**
     * @return Observer
     */
    public function build()
    {
        return new Observer($this->getObservedFactoryInterfaceMock());
    }

    public function testDispatchNotification()
    {
        /***
         * @var EventInterface|\PHPUnit_Framework_MockObject_MockObject $instance
         */
        $event = $this->createMock('Teknoo\States\LifeCycle\Event\Event', [], [], '', false);
        /*
         * @var ObservedInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->createMock('Teknoo\States\LifeCycle\Observing\ObservedInterface');
        $instance->expects($this->any())->method('getLastEvent')->willReturn($event);
        $service = $this->build();
        /*
         * @var TokenizerInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $tokenizer = $this->createMock('Teknoo\States\LifeCycle\Tokenization\TokenizerInterface');
        $tokenizer->expects($this->once())
            ->method('getToken')
            ->with($event)
            ->willReturn(['event_name1', 'event_name1:state1', 'event_name1:state2', 'event_name1:+state1', 'event_name1:-state3']);

        /*
         * @var EventDispatcherInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $dispatcher = $this->createMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
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
