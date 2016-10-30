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
namespace Teknoo\Tests\States\LifeCycle;

use Teknoo\States\LifeCycle\Generator;
use Teknoo\States\LifeCycle\Observing\EventDispatcherBridgeInterface;
use Teknoo\States\LifeCycle\Observing\ObserverInterface;
use Teknoo\States\LifeCycle\Scenario\ManagerInterface;
use Teknoo\States\LifeCycle\Tokenization\TokenizerInterface;

/**
 * Class GeneratorTest.
 *
 * @covers \Teknoo\States\LifeCycle\Generator
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Generator
     */
    protected function buildGenerator() : Generator
    {
        return new Generator();
    }

    public function testGetTokenizer()
    {
        $generator = $this->buildGenerator();
        $tokenizer1 = $generator->getTokenizer();
        $tokenizer2 = $generator->getTokenizer();
        self::assertInstanceOf(TokenizerInterface::class, $tokenizer1);
        self::assertSame($tokenizer1, $tokenizer2);
    }

    public function testSetTokenizer()
    {
        $generator = $this->buildGenerator();
        $tokenizer1 = $generator->getTokenizer();
        self::assertInstanceOf(
            Generator::class,
            $generator->setTokenizer($this->createMock(TokenizerInterface::class))
        );
        $tokenizer2 = $generator->getTokenizer();
        self::assertInstanceOf(TokenizerInterface::class, $tokenizer1);
        self::assertInstanceOf(TokenizerInterface::class, $tokenizer2);
        self::assertNotSame($tokenizer1, $tokenizer2);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetEventDispatcher()
    {
        $generator = $this->buildGenerator();
        $generator->getEventDispatcher();
    }

    public function testSetEventDispatcher()
    {
        $generator = $this->buildGenerator();
        self::assertInstanceOf(
            Generator::class,
            $generator->setEventDispatcher($this->createMock(EventDispatcherBridgeInterface::class))
        );
        $eventDispatcher = $generator->getEventDispatcher();
        self::assertInstanceOf(EventDispatcherBridgeInterface::class, $eventDispatcher);
    }

    public function testGetManager()
    {
        $generator = $this->buildGenerator();
        self::assertInstanceOf(
            Generator::class,
            $generator->setEventDispatcher($this->createMock(EventDispatcherBridgeInterface::class))
        );

        $manager1 = $generator->getManager();
        $manager2 = $generator->getManager();
        self::assertInstanceOf(ManagerInterface::class, $manager1);
        self::assertSame($manager1, $manager2);
    }

    public function testSetManager()
    {
        $generator = $this->buildGenerator();
        self::assertInstanceOf(
            Generator::class,
            $generator->setEventDispatcher($this->createMock(EventDispatcherBridgeInterface::class))
        );
        $manager1 = $generator->getManager();
        self::assertInstanceOf(
            Generator::class,
            $generator->setManager($this->createMock(ManagerInterface::class))
        );
        $manager2 = $generator->getManager();
        self::assertInstanceOf(ManagerInterface::class, $manager1);
        self::assertInstanceOf(ManagerInterface::class, $manager2);
        self::assertNotSame($manager1, $manager2);
    }

    public function testGetObserver()
    {
        $generator = $this->buildGenerator();
        self::assertInstanceOf(
            Generator::class,
            $generator->setEventDispatcher($this->createMock(EventDispatcherBridgeInterface::class))
        );
        $observer1 = $generator->getObserver();
        $observer2 = $generator->getObserver();
        self::assertInstanceOf(ObserverInterface::class, $observer1);
        self::assertSame($observer1, $observer2);
    }

    public function testSetObserver()
    {
        $generator = $this->buildGenerator();
        self::assertInstanceOf(
            Generator::class,
            $generator->setEventDispatcher($this->createMock(EventDispatcherBridgeInterface::class))
        );
        $observer1 = $generator->getObserver();
        self::assertInstanceOf(
            Generator::class,
            $generator->setObserver($this->createMock(ObserverInterface::class))
        );
        $observer2 = $generator->getObserver();
        self::assertInstanceOf(ObserverInterface::class, $observer1);
        self::assertInstanceOf(ObserverInterface::class, $observer2);
        self::assertNotSame($observer1, $observer2);
    }
}
