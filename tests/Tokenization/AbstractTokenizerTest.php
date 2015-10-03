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

use UniAlteri\States\LifeCycle\Tokenization\TokenizerInterface;
use UniAlteri\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;

/**
 * Class AbstractTokenizerTest.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
abstract class AbstractTokenizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return TokenizerInterface
     */
    abstract public function build();

    /**
     * @expectedException \TypeError
     */
    public function testGetTokenBadArgument()
    {
        $this->build()->getToken(new \stdClass());
    }

    public function testGetToken()
    {
        /*
         * @var EventInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->getMock('UniAlteri\States\LifeCycle\Event\EventInterface');
        $instance->expects($this->any())->method('getObject')->willReturn(new Acme());
        $this->assertTrue(is_array($this->build()->getToken($instance)));
    }
}
