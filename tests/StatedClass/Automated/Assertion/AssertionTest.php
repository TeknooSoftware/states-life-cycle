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

use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Assertion;
use Teknoo\States\Proxy\ProxyInterface;
use Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;

/**
 * Class AssertionTest
 *
 * @covers Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Assertion
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class AssertionTest extends AbstractAssertionTest
{
    /**
     * @return Assertion
     */
    public function buildInstance()
    {
        return new Assertion(['state1', 'state2']);
    }

    public function testWithClosure()
    {
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Assertion',
            $this->buildInstance()->with('fooBar', function () {})
        );
    }

    public function testWithValue()
    {
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Assertion',
            $this->buildInstance()->with('fooBar', 42)
        );
    }

    /**
     * @expectedException \TypeError
     */
    public function testWithBadPropertyName()
    {
        $this->buildInstance()->with(new \stdClass(), 42);
    }

    public function testIsValidPropertyValueBadValue()
    {
        $proxyMock = new Acme();
        $proxyMock->setFoo('error');

        $this->assertFalse($this->buildInstance()->with('foo', 'bar')->isValid($proxyMock));
    }

    public function testIsValidPropertyValueBadParameter()
    {
        /**
         * @var ProxyInterface|\PHPUnit_Framework_MockObject_MockObject $proxyMock
         */
        $proxyMock = $this->getMock('Teknoo\States\Proxy\ProxyInterface');

        $this->assertFalse($this->buildInstance()->with('foo', 'bar')->isValid($proxyMock));
    }

    public function testIsValidPropertyValue()
    {
        $proxyMock = new Acme();
        $proxyMock->setFoo('bar');

        $this->assertTrue($this->buildInstance()->with('foo', 'bar')->isValid($proxyMock));
    }
    
    public function testIsValidCallbackValueBadValue()
    {
        $proxyMock = new Acme();
        $proxyMock->setFoo('error');

        $this->assertFalse($this->buildInstance()->with('foo', function($value) {return 'bar'===$value;})->isValid($proxyMock));
    }

    public function testIsValidCallbackValueBadParameter()
    {
        /**
         * @var ProxyInterface|\PHPUnit_Framework_MockObject_MockObject $proxyMock
         */
        $proxyMock = $this->getMock('Teknoo\States\Proxy\ProxyInterface');

        $this->assertFalse($this->buildInstance()->with('foo', function($value) {return 'bar'===$value;})->isValid($proxyMock));
    }

    public function testIsValidCallbackValue()
    {
        $proxyMock = new Acme();
        $proxyMock->setFoo('bar');

        $this->assertTrue($this->buildInstance()->with('foo', function($value) {return 'bar'===$value;})->isValid($proxyMock));
    }

    public function testIsValidSeveralGood()
    {
        $assertion = $this->buildInstance()
            ->with('foo1', 'bar1')
            ->with('foo2', function($value) {return 'bar2'===$value;});

        $proxyMock = new Acme();
        $proxyMock->setFoo1('bar1')->setFoo2('bar2');

        $this->assertTrue($assertion->isValid($proxyMock));
    }

    public function testIsValidSeveralGoodOneError()
    {
        $assertion = $this->buildInstance()
            ->with('foo1', 'bar1')
            ->with('foo2', function($value) {return 'bar2'===$value;});

        $proxyMock = new Acme();
        $proxyMock->setFoo1('bar1')->setFoo2('bar');

        $this->assertFalse($assertion->isValid($proxyMock));
    }
}
