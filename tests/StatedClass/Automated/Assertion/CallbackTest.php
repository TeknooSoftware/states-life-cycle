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

namespace Teknoo\Tests\States\LifeCycle\StatedClass\Automated\Assertion;

use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Callback;

/**
 * Class CallbackTest
 *
 * @covers Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Callback
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class CallbackTest extends AbstractAssertionTest
{
    /**
     * @return Callback
     */
    public function buildInstance()
    {
        return new Callback(['state1', 'state2']);
    }

    public function testCallClosure()
    {
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Callback',
            $this->buildInstance()->call(function () {})
        );
    }

    public function testCallCalback()
    {
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Callback',
            $this->buildInstance()->call('time')
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testBadCallable()
    {
        $this->buildInstance()->call('badFunctionName');
    }

    public function testIsValid()
    {
        $proxy = $this->getMock('Teknoo\States\Proxy\ProxyInterface');
        $instance = $this->buildInstance()->call(function ($value) use ($proxy) {return $value === $proxy;});
        $this->assertTrue($instance->isValid($proxy));
        $this->assertFalse($instance->isValid($this->getMock('Teknoo\States\Proxy\ProxyInterface')));
    }
}