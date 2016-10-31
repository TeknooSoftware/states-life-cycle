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

namespace demo\AutomatedAcme;

use demo\AutomatedAcme\States\State1;
use demo\AutomatedAcme\States\State2;
use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Assertion;
use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\AssertionInterface;
use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Property\IsEqual;
use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Property\IsNull;
use Teknoo\States\LifeCycle\StatedClass\Automated\AutomatedInterface;
use Teknoo\States\LifeCycle\StatedClass\Automated\AutomatedTrait;
use Teknoo\States\Proxy\Standard;

/**
 * Class AutomatedAcme.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class AutomatedAcme extends Standard implements AutomatedInterface
{
    use AutomatedTrait;

    /**
     * For AssertionTest.
     *
     * @var mixed
     */
    protected $foo;

    /**
     * For AssertionTest.
     *
     * @var mixed
     */
    protected $foo1;

    /**
     * For AssertionTest.
     *
     * @var mixed
     */
    protected $foo2;

    /**
     * @param mixed $foo
     *
     * @return self
     */
    public function setFoo($foo)
    {
        $this->foo = $foo;

        return $this;
    }

    /**
     * @param mixed $foo1
     *
     * @return self
     */
    public function setFoo1($foo1)
    {
        $this->foo1 = $foo1;

        return $this;
    }

    /**
     * @param mixed $foo2
     *
     * @return self
     */
    public function setFoo2($foo2)
    {
        $this->foo2 = $foo2;

        return $this;
    }

    /**
     * @return AssertionInterface[]
     */
    public function getStatesAssertions(): array
    {
        return [
            (new Assertion([State1::class]))->with('foo', 'bar'),
            (new Assertion([State2::class]))->with('foo1', new IsEqual('bar1'))->with('foo2', new IsNull()),
        ];
    }

    /**
     * @return array
     */
    public static function statesListDeclaration(): array
    {
        return [
            State1::class,
            State2::class,
        ];
    }
}
