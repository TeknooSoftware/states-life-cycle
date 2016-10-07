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
namespace Teknoo\Tests\States\LifeCycle\Functional\ListenEvents\ClassA;

use Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface;
use Teknoo\States\LifeCycle\StatedClass\LifeCyclableTrait;
use Teknoo\States\Proxy;
use Teknoo\Tests\States\LifeCycle\Functional\ListenEvents\ClassA\States\State2;
use Teknoo\Tests\States\LifeCycle\Functional\ListenEvents\ClassA\States\State3;
use Teknoo\Tests\States\LifeCycle\Functional\ListenEvents\ClassA\States\StateDefault;

/**
 * Proxy ClassA
 * Proxy class of the stated class ClassA.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class ClassA extends Proxy\Standard  implements LifeCyclableInterface
{
    use LifeCyclableTrait;

    /**
     * @return array
     */
    public static function statesListDeclaration(): array
    {
        return [
            State2::class,
            State3::class,
            StateDefault::class
        ];
    }
}
