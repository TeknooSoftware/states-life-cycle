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
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */

namespace Teknoo\Tests\States\LifeCycle\StatedClass\Automated;

use Teknoo\States\LifeCycle\StatedClass\Automated\AutomatedInterface;

/**
 * Class AbstractAutomatedTest.
 *
 * @covers Teknoo\States\LifeCycle\StatedClass\Automated\AutomatedTrait
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
abstract class AbstractAutomatedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return AutomatedInterface
     */
    abstract public function buildInstance();

    public function testGetStatesAssertions()
    {
        $instance = $this->buildInstance();
        $this->assertTrue(is_array($instance->getStatesAssertions()));

        foreach ($instance->getStatesAssertions() as $assertion) {
            $this->assertInstanceOf(
                'Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\AssertionInterface',
                $assertion
            );
        }
    }
}
