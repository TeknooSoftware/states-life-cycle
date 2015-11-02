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

namespace Teknoo\Tests\States\LifeCycle\StatedClass\Automated\Assertion\Property;
use Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Property\IsSame;

/**
 * Class IsSameTest.
 *
 * @covers Teknoo\States\LifeCycle\StatedClass\LifeCyclableTrait
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class IsSameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return IsSame
     */
    public function buildInstance()
    {
        return new IsSame(10);
    }

    public function testSameProperty()
    {
        $this->assertTrue($this->buildInstance()(10));
    }

    public function testNotSameProperty()
    {
        $this->assertFalse($this->buildInstance()('10'));
    }
}