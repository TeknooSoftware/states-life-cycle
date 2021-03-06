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

namespace Teknoo\Tests\States\LifeCycle\StatedClass\Automated\Assertion\Property;

use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Property\IsNotInstanceOf;

/**
 * Class IsNotInstanceOfTest.
 *
 * @covers \Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Property\IsNotInstanceOf
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class IsNotInstanceOfTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return IsNotInstanceOf
     */
    public function buildInstance()
    {
        return new IsNotInstanceOf('\DateTime');
    }

    public function testNotInstanceProperty()
    {
        self::assertTrue($this->buildInstance()(new \stdClass()));
    }

    public function testInstanceOfProperty()
    {
        self::assertFalse($this->buildInstance()(new \DateTime()));
    }
}
