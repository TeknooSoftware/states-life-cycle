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
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */

namespace Teknoo\Tests\States\LifeCycle\Tokenization;

use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\Tokenization\Tokenizer;
use Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;

/**
 * Class TokenizerTest.
 *
 * @covers \Teknoo\States\LifeCycle\Tokenization\Tokenizer
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class TokenizerTest extends AbstractTokenizerTest
{
    /**
     * @return Tokenizer
     */
    public function build()
    {
        return new Tokenizer();
    }

    /**
     * @expectedException \TypeError
     */
    public function testGetStatedClassNameTokenBadArg()
    {
        $this->build()->getStatedClassNameToken(new \stdClass());
    }

    public function testGetStatedClassNameToken()
    {
        self::assertEquals(
            'teknoo_tests_states_lifecycle_statedclass_support_acme',
            $this->build()->getStatedClassNameToken('Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme')
        );
    }

    public function testGetStatedClassNameTokenFull()
    {
        self::assertEquals(
            'teknoo_tests_states_lifecycle_statedclass_support_acme',
            $this->build()->getStatedClassNameToken('Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme', true)
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testGetStatedClassInstanceTokenBadArg()
    {
        $this->build()->getStatedClassInstanceToken(new \stdClass());
    }

    public function testGetStatedClassInstanceToken()
    {
        self::assertEquals(
            'teknoo_tests_states_lifecycle_statedclass_support_acme',
            $this->build()->getStatedClassInstanceToken(new Acme())
        );
    }

    public function testGetTokenValue()
    {
        /*
         * @var EventInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->createMock(EventInterface::class);
        $instance->expects(self::any())->method('getObject')->willReturn(new Acme());
        $instance->expects(self::any())->method('getEnabledStates')->willReturn(['state1', 'state2', 'state3']);
        $instance->expects(self::any())->method('getIncomingStates')->willReturn(['state1', 'state2']);
        $instance->expects(self::any())->method('getOutgoingStates')->willReturn(['state4']);

        self::assertEquals(
            [
                'teknoo_tests_states_lifecycle_statedclass_support_acme',
                'teknoo_tests_states_lifecycle_statedclass_support_acme:state1',
                'teknoo_tests_states_lifecycle_statedclass_support_acme:state2',
                'teknoo_tests_states_lifecycle_statedclass_support_acme:state3',
                'teknoo_tests_states_lifecycle_statedclass_support_acme:+state1',
                'teknoo_tests_states_lifecycle_statedclass_support_acme:+state2',
                'teknoo_tests_states_lifecycle_statedclass_support_acme:-state4',
            ],
            $this->build()->getToken($instance)
        );
    }
}
