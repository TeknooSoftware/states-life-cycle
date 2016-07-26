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
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
namespace Teknoo\Tests\States\LifeCycle\Trace;

use Teknoo\States\LifeCycle\Generator;

/**
 * Class GeneratorTest.
 *
 * @covers Teknoo\States\LifeCycle\Generator
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
        $this->assertInstanceOf('Teknoo\States\LifeCycle\Tokenization\TokenizerInterface', $tokenizer1);
        $this->assertSame($tokenizer1, $tokenizer2);
    }

    public function testSetTokenizer()
    {
        $generator = $this->buildGenerator();
        $tokenizer1 = $generator->getTokenizer();
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Generator',
            $generator->setTokenizer($this->getMock('Teknoo\States\LifeCycle\Tokenization\TokenizerInterface'))
        );
        $tokenizer2 = $generator->getTokenizer();
        $this->assertInstanceOf('Teknoo\States\LifeCycle\Tokenization\TokenizerInterface', $tokenizer1);
        $this->assertInstanceOf('Teknoo\States\LifeCycle\Tokenization\TokenizerInterface', $tokenizer2);
        $this->assertNotSame($tokenizer1, $tokenizer2);
    }

    public function testGetEventDispatcher()
    {
        $generator = $this->buildGenerator();
        $eventDispatcher1 = $generator->getEventDispatcher();
        $eventDispatcher2 = $generator->getEventDispatcher();
        $this->assertInstanceOf('Symfony\Component\EventDispatcher\EventDispatcherInterface', $eventDispatcher1);
        $this->assertSame($eventDispatcher1, $eventDispatcher2);
    }

    public function testSetEventDispatcher()
    {
        $generator = $this->buildGenerator();
        $eventDispatcher1 = $generator->getEventDispatcher();
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Generator',
            $generator->setEventDispatcher($this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface'))
        );
        $eventDispatcher2 = $generator->getEventDispatcher();
        $this->assertInstanceOf('Symfony\Component\EventDispatcher\EventDispatcherInterface', $eventDispatcher1);
        $this->assertInstanceOf('Symfony\Component\EventDispatcher\EventDispatcherInterface', $eventDispatcher2);
        $this->assertNotSame($eventDispatcher1, $eventDispatcher2);
    }

    public function testGetManager()
    {
        $generator = $this->buildGenerator();
        $manager1 = $generator->getManager();
        $manager2 = $generator->getManager();
        $this->assertInstanceOf('Teknoo\States\LifeCycle\Scenario\ManagerInterface', $manager1);
        $this->assertSame($manager1, $manager2);
    }

    public function testSetManager()
    {
        $generator = $this->buildGenerator();
        $manager1 = $generator->getManager();
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Generator',
            $generator->setManager($this->getMock('Teknoo\States\LifeCycle\Scenario\ManagerInterface'))
        );
        $manager2 = $generator->getManager();
        $this->assertInstanceOf('Teknoo\States\LifeCycle\Scenario\ManagerInterface', $manager1);
        $this->assertInstanceOf('Teknoo\States\LifeCycle\Scenario\ManagerInterface', $manager2);
        $this->assertNotSame($manager1, $manager2);
    }

    public function testGetObserver()
    {
        $generator = $this->buildGenerator();
        $observer1 = $generator->getObserver();
        $observer2 = $generator->getObserver();
        $this->assertInstanceOf('Teknoo\States\LifeCycle\Observing\ObserverInterface', $observer1);
        $this->assertSame($observer1, $observer2);
    }

    public function testSetObserver()
    {
        $generator = $this->buildGenerator();
        $observer1 = $generator->getObserver();
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Generator',
            $generator->setObserver($this->getMock('Teknoo\States\LifeCycle\Observing\ObserverInterface'))
        );
        $observer2 = $generator->getObserver();
        $this->assertInstanceOf('Teknoo\States\LifeCycle\Observing\ObserverInterface', $observer1);
        $this->assertInstanceOf('Teknoo\States\LifeCycle\Observing\ObserverInterface', $observer2);
        $this->assertNotSame($observer1, $observer2);
    }
}
