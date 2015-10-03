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

namespace UniAlteri\Tests\States\LifeCycle\Tokenization;

use UniAlteri\States\LifeCycle\Tokenization\Tokenizer;
use UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;

/**
 * Class TokenizerTest.
 *
 * @covers UniAlteri\States\LifeCycle\Tokenization\Tokenizer
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
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
        $this->assertEquals(
            'unialteri_tests_states_lifecycle_statedclass_support_acme',
            $this->build()->getStatedClassNameToken('UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme')
        );
    }

    public function testGetStatedClassNameTokenFull()
    {
        $this->assertEquals(
            'unialteri_tests_states_lifecycle_statedclass_support_acme',
            $this->build()->getStatedClassNameToken('UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme', true)
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
        $this->assertEquals(
            'unialteri_tests_states_lifecycle_statedclass_support_acme',
            $this->build()->getStatedClassInstanceToken(new Acme())
        );
    }

    public function testGetTokenValue()
    {
        /*
         * @var EventInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $instance->expects($this->any())->method('getObject')->willReturn(new Acme());
        $instance->expects($this->any())->method('getEnabledStates')->willReturn(['state1', 'state2', 'state3']);
        $instance->expects($this->any())->method('getIncomingStates')->willReturn(['state1', 'state2']);
        $instance->expects($this->any())->method('getOutgoingStates')->willReturn(['state4']);

        $this->assertEquals(
            [
                'unialteri_tests_states_lifecycle_statedclass_support_acme',
                'unialteri_tests_states_lifecycle_statedclass_support_acme:state1',
                'unialteri_tests_states_lifecycle_statedclass_support_acme:state2',
                'unialteri_tests_states_lifecycle_statedclass_support_acme:state3',
                'unialteri_tests_states_lifecycle_statedclass_support_acme:+state1',
                'unialteri_tests_states_lifecycle_statedclass_support_acme:+state2',
                'unialteri_tests_states_lifecycle_statedclass_support_acme:-state4',
            ],
            $this->build()->getToken($instance)
        );
    }
}
