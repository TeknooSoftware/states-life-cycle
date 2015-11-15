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

namespace Teknoo\Tests\States\LifeCycle\StatedClass\Support\AutomatedAcme;

use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Assertion;
use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\AssertionInterface;
use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Property\IsEqual;
use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Property\IsNull;
use Teknoo\States\LifeCycle\StatedClass\Automated\AutomatedInterface;
use Teknoo\States\LifeCycle\StatedClass\Automated\AutomatedTrait;
use Teknoo\States\Proxy\Integrated;

/**
 * Class AutomatedAcme.
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class AutomatedAcme extends Integrated implements AutomatedInterface
{
    use AutomatedTrait;

    /**
     * For AssertionTest
     * @var mixed
     */
    protected $foo;

    /**
     * For AssertionTest
     * @var mixed
     */
    protected $foo1;

    /**
     * For AssertionTest
     * @var mixed
     */
    protected $foo2;

    /**
     * @param mixed $foo
     * @return self
     */
    public function setFoo($foo)
    {
        $this->foo = $foo;

        return $this;
    }

    /**
     * @param mixed $foo1
     * @return self
     */
    public function setFoo1($foo1)
    {
        $this->foo1 = $foo1;

        return $this;
    }

    /**
     * @param mixed $foo2
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
            (new Assertion(['State1']))->with('foo', 'bar'),
            (new Assertion(['State2']))->with('foo1', new IsEqual('bar1'))->with('foo2', new IsNull())
        ];
    }
}
